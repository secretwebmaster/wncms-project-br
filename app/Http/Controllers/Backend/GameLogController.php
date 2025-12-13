<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class GameLogController extends BackendController
{
    protected array $cacheTags = ['game_logs'];

    public function index(Request $request)
    {
        $gameLogs = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->paginate(20);

        return $this->view('backend.game_logs.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.game_log')]),
            'gameLogs' => $gameLogs,
        ]);
    }

    public function create(int|string|null $id = null)
    {
        $gameLog = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$gameLog) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.game_log')]));
        }

        return $this->view('backend.game_logs.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.game_log')]),
            'gameLog' => $gameLog,
        ]);
    }

    public function store(Request $request)
    {
        $gameLog = $this->modelClass::create([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('game_logs.edit', ['id' => $gameLog->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $gameLog = $this->modelClass::find($id);
        if (!$gameLog) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.game_log')]));
        }

        return $this->view('backend.game_logs.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.game_log')]),
            'gameLog' => $gameLog,
        ]);
    }

    public function update(Request $request, $id)
    {
        $gameLog = $this->modelClass::find($id);
        if (!$gameLog) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.game_log')]));
        }

        $gameLog->update([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('game_logs.edit', ['id' => $gameLog->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
