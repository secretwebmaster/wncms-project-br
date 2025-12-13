<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Game;
use App\Models\Player;
use App\Services\Managers\GameManager;

class MovePlayer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'br:move-player {game_id} {player_id} {x} {y}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Move a player to a specific location in a game';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $gameId = (int) $this->argument('game_id');
        $playerId = (int) $this->argument('player_id');
        $x = (int) $this->argument('x');
        $y = (int) $this->argument('y');

        $game = Game::find($gameId);
        if (!$game) {
            $this->error("Game {$gameId} not found");
            return Command::FAILURE;
        }

        $player = Player::where('game_id', $game->id)->find($playerId);
        if (!$player) {
            $this->error("Player {$playerId} not found in game {$gameId}");
            return Command::FAILURE;
        }

        $originalX = $player->location_x;
        $originalY = $player->location_y;

        // Update player position directly
        $player->update([
            'location_x' => $x,
            'location_y' => $y,
        ]);

        $gm = new GameManager($game, $player);

        // Record movement log
        $gm->log($player, 'player_move', [
            'player_id' => $player->id,
            'from_x' => $originalX,
            'from_y' => $originalY,
            'to_x' => $x,
            'to_y' => $y,
        ]);

        // Generate random item in visible range (optional but useful)
        $range = $gm->getMapRange($player);
        $gm->generateRandomItem($range['x'], $range['y']);

        // Detect items on tile
        $items = $gm->getItemOnTile($x, $y);
        if ($items->isNotEmpty()) {
            $this->info("Items found on tile: " . $items->count());
        }

        // Detect other players on tile
        $others = $gm->getOhterPlayerOnTile($player);
        if ($others->isNotEmpty()) {
            $this->info("Other players on tile: " . $others->count());
        }

        $gm->log($player, 'player_teleport', [
            'player_id' => $player->id,
            'x' => $x,
            'y' => $y,
        ]);

        $this->info("Player {$player->id} moved from ({$originalX}, {$originalY}) to ({$x}, {$y})");

        return Command::SUCCESS;
    }
}
