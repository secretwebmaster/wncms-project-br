<?php

namespace App\Services\Managers;

use App\Models\Game;
use App\Models\GameLog;
use App\Models\GameLogTemplate;
use App\Models\ItemTemplate;
use App\Models\Player;
use Illuminate\Support\Lottery;
use App\Models\Item;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

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

    public function getOtherPlayerOnTile($player)
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

    public function equipItem(Player $player, Item $item)
    {
        if ($item->player_id !== $player->id) {
            throw new InvalidArgumentException('Item not owned by player');
        }

        $template = $item->item_template;
        if (!$template || !$template->isEquippable()) {
            throw new InvalidArgumentException('Item not equippable');
        }

        $slot = $template->slot;

        DB::transaction(function () use ($player, $item, $slot) {
            // auto replace: unequip same slot
            $player->equippedItemsInSlot($slot)->update([
                'is_equipped' => false,
            ]);

            $item->update([
                'is_equipped' => true,
            ]);
        });

        // log
        $this->log($player, null, 'player_equip_item', [
            'player_id' => $player->id,
            'item_id' => $item->id,
            'slot' => $slot,
        ]);

        return true;
    }

    public function unequipItem(Player $player, Item $item)
    {
        if ($item->player_id !== $player->id) {
            throw new InvalidArgumentException('Item not owned by player');
        }

        if (!$item->is_equipped) {
            return false;
        }

        $item->update([
            'is_equipped' => false,
        ]);

        $this->log($player, null, 'player_unequip_item', [
            'player_id' => $player->id,
            'item_id' => $item->id,
        ]);

        return true;
    }

    //! Record
    public function log(?Player $actor, ?Player $target, string $key, array $data)
    {
        $gameLogTemplate = GameLogTemplate::where('key', $key)->first();

        if (!$gameLogTemplate) {
            info("GameLogTemplate not found for key: {$key}");
            return false;
        }

        $gameLog = GameLog::create([
            'game_id' => $this->game->id,
            'actor_player_id' => $actor?->id,
            'target_player_id' => $target?->id,
            'game_log_template_id' => $gameLogTemplate->id,
            'data' => $data,
        ]);

        info("GameLog created", [
            'id' => $gameLog->id,
            'actor_player_id' => $actor?->id,
            'target_player_id' => $target?->id,
            'key' => $key,
        ]);

        return $gameLog;
    }


    public function renderGameLog(GameLog $gameLog, Player $viewer)
    {
        $template = $gameLog->game_log_template;
        if (!$template) return '';

        $data = $gameLog->data ?? [];

        $viewerRole = $this->detectViewerRole($gameLog, $viewer);

        $data['viewer_role'] = $viewerRole;

        $variant = $this->pickVariant($template, $data);

        $content = $variant?->content ?? $template->content;

        $data = $gameLog->data;
        $pattern = '/\[keyword ([^\]]+)\]/';

        // Use the preg_replace_callback function to replace the placeholders
        $parsedContent = preg_replace_callback($pattern, function ($match) use ($data, $viewer) {

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

                            // viewer-aware "you"
                            if (
                                $params['m'] === 'player' &&
                                (int) $data[$dataKey] === (int) $viewer->id
                            ) {
                                $value = __('wncms::word.you');
                            } else {
                                $value = $modelClass::where($modelColumn, $data[$dataKey])
                                    ->value($outputColumn);
                            }
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

    protected function pickVariant(GameLogTemplate $template, array $data): ?object
    {
        return $template->variants
            ->where('is_active', 1)
            ->filter(fn($variant) => $this->matchConditionTree($variant->conditions, $data))
            ->sortByDesc('priority')
            ->first();
    }

    protected function matchConditionTree(?array $node, array $data): bool
    {
        if (!$node) return false;

        // leaf
        if (isset($node['field'])) {
            $left = $data[$node['field']] ?? null;
            $right = $node['value'] ?? null;
            $op = $node['operator'] ?? '=';

            return match ($op) {
                '='  => $left == $right,
                '!=' => $left != $right,
                '>'  => $left >  $right,
                '>=' => $left >= $right,
                '<'  => $left <  $right,
                '<=' => $left <= $right,
                'in' => is_array($right) && in_array($left, $right),
                'not_in' => is_array($right) && !in_array($left, $right),
                default => false,
            };
        }

        // group
        $type = $node['type'] ?? 'and';
        $children = $node['children'] ?? [];

        if ($type === 'and') {
            foreach ($children as $child) {
                if (!$this->matchConditionTree($child, $data)) return false;
            }
            return true;
        }

        if ($type === 'or') {
            foreach ($children as $child) {
                if ($this->matchConditionTree($child, $data)) return true;
            }
            return false;
        }

        return false;
    }

    protected function detectViewerRole(GameLog $gameLog, Player $viewer): string
    {
        $data = $gameLog->data ?? [];

        if (!empty($data['attacker_id']) && (int) $data['attacker_id'] === (int) $viewer->id) {
            return 'attacker';
        }

        if (!empty($data['defender_id']) && (int) $data['defender_id'] === (int) $viewer->id) {
            return 'defender';
        }

        return 'other';
    }
}
