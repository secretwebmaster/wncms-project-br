<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class PlayerActionController extends BackendController
{
    protected array $cacheTags = ['player_actions'];

    public function index(Request $request)
    {
        $playerActions = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->paginate($request->page_size ?? 20);

        return $this->view('backend.player_actions.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.player_action')]),
            'playerActions' => $playerActions,
        ]);
    }

    public function create($id = null)
    {
        $playerAction = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$playerAction) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.player_action')]));
        }

        return $this->view('backend.player_actions.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.player_action')]),
            'playerAction' => $playerAction,
        ]);
    }

    public function store(Request $request)
    {
        $playerAction = $this->modelClass::create([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('player_actions.edit', ['id' => $playerAction->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $playerAction = $this->modelClass::find($id);
        if (!$playerAction) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.player_action')]));
        }

        return $this->view('backend.player_actions.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.player_action')]),
            'playerAction' => $playerAction,
        ]);
    }

    public function update(Request $request, $id)
    {
        $playerAction = $this->modelClass::find($id);
        if (!$playerAction) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.player_action')]));
        }

        $playerAction->update([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('player_actions.edit', ['id' => $playerAction->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
