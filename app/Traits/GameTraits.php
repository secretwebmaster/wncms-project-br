<?php

namespace App\Traits;

use App\Models\Game;
use App\Services\Managers\GameManager;
use Illuminate\Http\Request;

trait GameTraits
{
    protected $gm;
    protected $game;
    protected $player;
    protected $items;
    protected $mapRange;
    protected $visibleRadius = 5;

    public function __construct(Request $request)
    {
        parent::__construct();
        if ($request->gameId) {
            // $this->game = Game::find($request->gameId);
            // $this->gm = new GameManager($this->game);

            $this->middleware(function ($request, $next) {
                $this->game = Game::find($request->gameId);
                $this->gm = new GameManager($this->game);
                $this->player = $this->game->players()->whereRelation('user', 'users.id', auth()->id())->latest()->first();
                return $next($request);
            });
        } else {
            // dd(1);
        }
    }

    public function renderMap()
    {
        //get item in map range
        $this->mapRange = $this->gm->getMapRange($this->player);
        $items = $this->game->items()->whereBetween('x', $this->mapRange['x'])->whereBetween('y', $this->mapRange['y'])->get();
        $players = $this->game->players()->where('id', '<>', $this->player->id)->get();
        return $this->view("{$this->theme}::parts.map", [
            'visibleRadius' => $this->visibleRadius,
            'player' => $this->player,
            'players' => $players,
            'items' => $items,
        ])->render();
    }

    public function renderEvent()
    {
        $gameLogs = $this->player
            ->game_logs()
            ->with(['game_log_template', 'game_log_template.variants'])
            ->orderByDesc('created_at')
            ->get();

        $gm = $this->gm;
        $viewer = $this->player;

        return $this->view("{$this->theme}::parts.event", [
            'game_logs' => $gameLogs,
            'renderGameLog' => function ($gameLog) use ($gm, $viewer) {
                return $gm->renderGameLog($gameLog, $viewer);
            },
        ])->render();
    }



    public function renderAction()
    {
        return $this->view("{$this->theme}::parts.action", [
            'actions' => $this->player->actions()->where('status', 'pending')->get(),
        ])->render();
    }

    public function renderInventory()
    {
        return $this->view("{$this->theme}::parts.inventory", [
            'player' => $this->player,
        ])->render();
    }
}
