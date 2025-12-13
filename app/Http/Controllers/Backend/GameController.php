<?php

namespace App\Http\Controllers\Backend;

use App\Models\Game;
use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class GameController extends BackendController
{
    protected $gm;
    protected $game;
    protected $player;
    protected $items;
    protected $mapRange;
    protected $visibleRadius = 5;

    public function index(Request $request)
    {
        $q = Game::query();
        $q->latest();
        $q->orderBy('id', 'desc');
        $games = $q->paginate($request->pag_size);
        $users = wncms()->getModelClass('user')::all();
        return view('backend.games.index', [
            'page_title' => wncms_model_word('game', 'management'),
            'games' => $games,
            'users' => $users,
            'statuses' => Game::STATUSES,
        ]);
    }

    public function create($id = null)
    {
        $game = Game::find($id);
        $users = wncms()->getModelClass('user')::all();
        return view('backend.games.create', [
            'page_title' => wncms_model_word('game', 'management'),
            'game' => $game,
            'users' => $users,
            'statuses' => Game::STATUSES,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $game = Game::create([
            'user_id' => $request->user_id,
            'status' => $request->status,
            'player_limit' => $request->player_limit,
            'remark' => $request->remark,
            'ended_at' => $request->ended_at,
        ]);

        cache()->tags(['games'])->flush();

        return redirect()->route('games.edit', [
            'game' => $game,
        ])->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $game = Game::find($id);
        $users = wncms()->getModelClass('user')::all();
        return view('backend.games.edit', [
            'page_title' => wncms_model_word('game', 'management'),
            'game' => $game,
            'users' => $users,
            'statuses' => Game::STATUSES,
        ]);
    }

    public function update(Request $request, $id)
    {
        $game = Game::find($id);
        // dd($request->all());
        $game->update([
            'user_id' => $request->user_id,
            'status' => $request->status,
            'player_limit' => $request->player_limit,
            'remark' => $request->remark,
            'ended_at' => $request->ended_at,
        ]);

        cache()->tags(['games'])->flush();

        return redirect()->route('games.edit', [
            'game' => $game,
        ])->withMessage(__('wncms::word.successfully_updated'));
    }

    public function destroy($id)
    {
        $game = Game::find($id);
        $game->delete();
        return redirect()->route('games.index')->withMessage(__('wncms::word.successfully_deleted'));
    }

    public function bulk_delete(Request $request)
    {
        Game::whereIn('id', explode(",", $request->model_ids))->delete();
        return redirect()->route('games.index')->withMessage(__('wncms::word.successfully_deleted'));
    }
}
