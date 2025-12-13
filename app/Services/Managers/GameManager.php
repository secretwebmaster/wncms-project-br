<?php

namespace App\Services\Managers;

use App\Models\Game;
use App\Models\GameLog;
use App\Models\GameLogTemplate;
use App\Models\ItemTemplate;
use App\Models\Player;
use Illuminate\Support\Lottery;

class GameManager
{

    protected $game;
    protected $player;
    protected $visibleRadius = 5;

    public function __construct(Game $game, ?Player $player = null)
    {
        $this->game = $game;
        $this->player =  $player ?? $this->game?->players()->whereRelation('user', 'users.id', auth()->id())->first();
    }

    public function generateMap()
    {
        return $this->game->map()->create([
            'type' => 'standard',
            'min_x' => -100,
            'min_y' => -100,
            'min_z' => -3,
            'max_x' => 100,
            'max_y' => 100,
            'max_z' => 3,
        ]);
    }

    public function generateMapEvent() {}

    public function generateRandomItem(array|int $x = [], array|int $y = [])
    {
        //lottery
        $chance = 0.5; // 80% chance
        $hasEvent = Lottery::odds(1, (1 / $chance))->choose();

        if ($hasEvent) {
            //get item template id by chance
            $itemTemplate = ItemTemplate::inRandomOrder()->first();

            //lottery count

            //random location
            if (
                $itemTemplate &&
                (is_numeric($x) || (is_array($x) && !empty($x[0]) && !empty($x[1]))) &&
                (is_numeric($y) || (is_array($y) && !empty($y[0]) && !empty($y[1])))
            ) {
                if (is_array($y) && !empty($y[0]) && !empty($y[1])) {
                    $y = rand($y[0], $y[1]);
                }
                if (is_array($x) && !empty($x[0]) && !empty($x[1])) {
                    $x = rand($x[0], $x[1]);
                }
                info("generating at {$x}, {$y}");
                //generate item
                $item = $this->game->items()->create([
                    'item_template_id' => $itemTemplate->id,
                    'player_id' => null,
                    'x' => $x,
                    'y' => $y,
                ]);

                //record

                return $item;
            }
        }

        //no event
        return false;
    }

    public function getMapRange(Player $player)
    {
        return [
            'x' => [$player->location_x - $this->visibleRadius, $player->location_x + $this->visibleRadius],
            'y' => [$player->location_y - $this->visibleRadius, $player->location_y + $this->visibleRadius],
        ];
    }

    public function getItemOnTile($x, $y)
    {
        return $this->game->items()->location($x, $y)->get();
    }

    public function getOhterPlayerOnTile($player)
    {
        return $this->game->players()->where('id', '<>', $player->id)->location($player->location_x, $player->location_y)->get();
    }


    //! Player
    public function playerMove($player, $direction)
    {
        switch ($direction) {
            case 'up-left':
                $moveX = -1;
                $moveY = -1;
                break;
            case 'up':
                $moveX = 0;
                $moveY = -1;
                break;
            case 'up-right':
                $moveX = 1;
                $moveY = -1;
                break;
            case 'left':
                $moveX = -1;
                $moveY = 0;
                break;
            case 'right':
                $moveX = 1;
                $moveY = 0;
                break;
            case 'down-left':
                $moveX = -1;
                $moveY = 1;
                break;
            case 'down':
                $moveX = 0;
                $moveY = 1;
                break;
            case 'down-right':
                $moveX = 1;
                $moveY = 1;
                break;
            default:
                $moveX = 0;  // Default values in case of an unknown direction
                $moveY = 0;
                break;
        }

        $originalX = $player->location_x;
        $originalY = $player->location_y;

        //update user location
        $player->update([
            'location_x' => $player->location_x += $moveX,
            'location_y' => $player->location_y += $moveY,
        ]);

        if ($originalX != $player->location_x || $originalY != $player->location_y) {
            return true;
        } else {
            return false;
        }
    }

    //! Record
    public function log($player, $key, $data)
    {
        $gameLogTemplate = GameLogTemplate::where('key', $key)->first();

        if (!$gameLogTemplate) {
            info("GameLogTemplate not found for key: {$key}");
            return false;
        }

        $gameLog = $player->game_logs()->create([
            'game_id' => $this->game->id,
            'game_log_template_id' => $gameLogTemplate->id,
            'data' => $data,
        ]);

        return $gameLog;
    }

    public function renderGameLog(GameLog $gameLog)
    {
        $content = $gameLog->game_log_template?->content;
        $data = $gameLog->data;
        $pattern = '/\[keyword ([^\]]+)\]/';


        // Use the preg_replace_callback function to replace the placeholders
        $parsedContent = preg_replace_callback($pattern, function ($match) use ($data) {

            if (!empty($match[1])) {
                $params = [];

                $strings = explode(" ", $match[1]);
                foreach (array_filter($strings) as $string) {
                    $k = explode("=", $string)[0];
                    $v = trim(explode("=", $string)[1] ?? '', '"');
                    $params[$k] = $v;
                }

                // ===== plain data keyword =====
                // [keyword key="damage" class="damage-number"]
                if (isset($params['key'])) {
                    $dataKey = $params['key'];
                    $spanClass = $params['class'] ?? null;

                    $value = $data[$dataKey] ?? '未知資料';

                    if (!empty($spanClass)) {
                        $value = "<span class='{$spanClass}'>{$value}</span>";
                    }

                    return $value;
                }

                // ===== model keyword =====
                // [keyword m="player" mk="id" mv="name" dk="attacker_id"]
                if (isset($params['m']) && isset($params['mk']) && isset($params['mv']) && isset($params['dk'])) {
                    $className = str($params['m'])->studly();
                    $modelClass = 'App\Models\\' . $className;
                    $modelColumn = $params['mk'];
                    $outputColumn = $params['mv'];
                    $dataKey = $params['dk'];
                    $spanClass = $params['class'] ?? null;

                    // special data
                    if ($className == 'Item' && $outputColumn == 'name') {
                        if (!empty($data[$dataKey])) {
                            $value = $modelClass::where($modelColumn, $data[$dataKey])
                                ->first()?->item_template?->{$outputColumn};
                        } else {
                            $value = '未知資料';
                        }
                    } else {
                        if (!empty($data[$dataKey])) {
                            $value = $modelClass::where($modelColumn, $data[$dataKey])
                                ->value($outputColumn);
                        } else {
                            $value = '未知資料';
                        }
                    }

                    if (!empty($spanClass)) {
                        $value = "<span class='{$spanClass}'>{$value}</span>";
                    }

                    return $value;
                }
            }

            // fallback: keep original text
            return $match[0];
        }, $content);


        return $parsedContent;
    }
}
