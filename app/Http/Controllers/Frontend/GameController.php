<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Game;
use App\Services\Managers\GameManager;
use Illuminate\Http\Request;
use Wncms\Http\Controllers\Frontend\FrontendController;
use App\Traits\GameTraits;

class GameController extends FrontendController
{
    use GameTraits;

    public function home(Request $request)
    {
        $activeGames = Game::where('status', 'active')->orderBy('created_at', 'desc')->get();
        $ranks = [];

        return $this->view($this->theme . "::games.index", [
            'activeGames' => $activeGames,
            'ranks' => $ranks,
        ]);
    }

    public function start(Request $request)
    {
        // dd('create game');
        // check if joinable game exists

        // if not, create new game
        $game = Game::create([
            'user_id' => auth()->id(),
            'status' => 'active',
            'player_limit' => gss('player_limit', 100),
        ]);

        $gm = new GameManager($game);
        $map = $gm->generateMap($game);

        // check if User already has a player in the game
        $existingPlayer = $game->players()->where('user_id', auth()->id())->first();
        if ($existingPlayer) {
            return redirect()->route('frontend.games.play', [
                'game' => $game,
                'player' => $existingPlayer,
                'map' => $game->map,
            ]);
        }

        if (auth()->check()) {
            return redirect()->route('frontend.games.play', [
                'game' => $game,
                // 'player' => $player,
                'map' => $map,
            ]);
        } else {
            return redirect()->route('login');
        }
    }

    public function play(Request $request, ?Game $game = null)
    {
        $user = auth()->user();

        if ($request->is_new_game) {
            $game = $user->games()->create(['status' => 'active']);
            $map = $this->gm->generateMap();
        } else {
            $game ??= $user->games()->orderBy('id', 'desc')->first();
            $map = $game->map;
        }

        $this->gm = new GameManager($game);

        $player = $game->players()->firstOrCreate(
            [
                'user_id' => $user->id,
                'game_id' => $game->id,
            ],
            [
                'type' => 'player',
                'status' => 'alive',
                'name' => __('wncms::word.player') . time() . rand(1, 100),
                'level' => 1,
                'exp' => 0,
                'exp_next' => 100,
                'hp' => 100,
                'max_hp' => 100,
                'mp' => 50,
                'max_mp' => 50,
                'vit' =>  rand(1, 10),
                'str' => rand(1, 10),
                'int' => rand(1, 10),
                'dex' => rand(1, 10),
                'luc' => rand(1, 10),
                'location_x' => rand(1, 100),
                'location_y' => rand(1, 100),
                'location_z' => 1,
                'previous_location_x' => null,
                'previous_location_y' => null,
                'previous_location_z' => null,
                'kill' => 0,
                'died_at' => null,
            ]
        );

        $this->mapRange = $this->gm->getMapRange($player);

        $items = $game->items()->whereBetween('x', $this->mapRange['x'])->whereBetween('y', $this->mapRange['y'])->get();
        $players = $game->players()->where('id', '<>', $player->id)->get();
        $game_logs = $player->getGameLogs();
        // dd($game_logs->first());

        //load map
        return $this->view($this->theme . "::games.play", [
            'visibleRadius' => $this->visibleRadius,
            'game' => $game,
            'player' => $player,
            'players' => $players,
            'map' => $map,
            'items' => $items,
            'actions' =>  $player->actions()->where('status', 'pending')->get(),
            'game_logs' => $game_logs,
        ]);
    }
}
