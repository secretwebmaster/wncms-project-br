<?php

namespace App\Http\Controllers\Backend;

use App\Models\Game;
use App\Models\Player;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Wncms\Http\Controllers\Backend\BackendController;

class PlayerController extends BackendController
{
    protected array $cacheTags = ['players'];

    public function index(Request $request)
    {
        $players = $this->modelClass::query()->orderBy('id', 'desc')->get();
        $gameIds = Game::pluck('id')->toArray();

        return $this->view('backend.players.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.player')]),
            'players' => $players,
            'gameIds' => $gameIds,
            'statuses' => Player::STATUSES,
            'types' => Player::TYPES,
        ]);
    }

    public function create(int|string|null $id = null)
    {
        $player = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$player) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.player')]));
        }

        return $this->view('backend.players.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.player')]),
            'player' => $player,
            'gameIds' => Game::pluck('id')->toArray(),
            'statuses' => Player::STATUSES,
            'types' => Player::TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $player = $this->modelClass::create([
            'game_id' => $request->game_id,
            'user_id' => $request->user_id,
            'type' => $request->type ?? 'player',
            'status' => $request->status ?? 'alive',
            'name' => $request->name ?? ('player-' . str()->uuid()),
            'level' => $request->level ?? 1,
            'exp' => $request->exp ?? 0,
            'exp_next' => $request->exp_next,
            'hp' => $request->hp,
            'max_hp' => $request->max_hp,
            'mp' => $request->mp,
            'max_mp' => $request->max_mp,
            'vit' => $request->vit,
            'str' => $request->str,
            'int' => $request->int,
            'dex' => $request->dex,
            'luc' => $request->luc,
            'location_x' => $request->location_x,
            'location_y' => $request->location_y,
            'location_z' => $request->location_z,
            'previous_location_x' => $request->previous_location_x,
            'previous_location_y' => $request->previous_location_y,
            'previous_location_z' => $request->previous_location_z,
            'kill' => $request->kill ?? 0,
            'died_at' => $request->died_at,
        ]);

        $this->handleThumbnail($request, $player);
        $this->flush();

        return redirect()->route('players.edit', ['id' => $player->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit(int|string $id)
    {
        $player = $this->modelClass::find($id);
        if (!$player) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.player')]));
        }

        return $this->view('backend.players.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.player')]),
            'player' => $player,
            'gameIds' => Game::pluck('id')->toArray(),
            'users' => User::all(),
            'statuses' => Player::STATUSES,
            'types' => Player::TYPES,
        ]);
    }

    public function update(Request $request, $id)
    {
        $player = $this->modelClass::find($id);
        if (!$player) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.player')]));
        }

        $player->update([
            'game_id' => $request->game_id,
            'user_id' => $request->user_id,
            'type' => $request->type ?? 'player',
            'status' => $request->status ?? 'alive',
            'name' => $request->name ?? ('player-' . str()->uuid()),
            'level' => $request->level ?? 1,
            'exp' => $request->exp ?? 0,
            'exp_next' => $request->exp_next,
            'hp' => $request->hp,
            'max_hp' => $request->max_hp,
            'mp' => $request->mp,
            'max_mp' => $request->max_mp,
            'vit' => $request->vit,
            'str' => $request->str,
            'int' => $request->int,
            'dex' => $request->dex,
            'luc' => $request->luc,
            'location_x' => $request->location_x,
            'location_y' => $request->location_y,
            'location_z' => $request->location_z,
            'previous_location_x' => $request->previous_location_x,
            'previous_location_y' => $request->previous_location_y,
            'previous_location_z' => $request->previous_location_z,
            'kill' => $request->kill ?? 0,
            'died_at' => $request->died_at,
        ]);

        $this->handleThumbnail($request, $player);
        $this->flush();

        return redirect()->route('players.edit', ['id' => $player->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }

    protected function handleThumbnail(Request $request, Player $player)
    {
        if ($request->player_thumbnail_remove) {
            $player->clearMediaCollection('player_thumbnail');
        }

        if ($request->player_thumbnail_clone_id) {
            $media = Media::find($request->player_thumbnail_clone_id);
            if ($media) {
                $media->copy($player, 'player_thumbnail');
            }
        }

        if ($request->hasFile('player_thumbnail')) {
            $player->addMediaFromRequest('player_thumbnail')->toMediaCollection('player_thumbnail');
        }
    }
}
