<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class GameLogTemplateController extends BackendController
{
    protected array $cacheTags = ['game_log_template'];

    public function index(Request $request)
    {
        $gameLogTemplates = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->paginate(20);

        return $this->view('backend.game_log_templates.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.game_log_template')]),
            'gameLogTemplates' => $gameLogTemplates,
            'types' => $this->modelClass::TYPES,
        ]);
    }

    public function create(int|string|null $id = null)
    {
        $gameLogTemplate = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$gameLogTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.game_log_template')]));
        }

        return $this->view('backend.game_log_templates.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.game_log_template')]),
            'gameLogTemplate' => $gameLogTemplate,
            'types' => $this->modelClass::TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $duplicated = $this->modelClass::where('key', $request->key)->first();
        if ($duplicated) {
            return back()->withErrors([
                'message' => __('wncms::word.duplocate_template_is_found', ['id' => $duplicated->id]),
            ]);
        }

        $gameLogTemplate = $this->modelClass::create([
            'type' => $request->type,
            'key' => $request->key,
            'remark' => $request->remark,
            'content' => $request->content,
        ]);

        $this->flush();

        return redirect()->route('game_log_templates.edit', ['id' => $gameLogTemplate->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $gameLogTemplate = $this->modelClass::find($id);
        if (!$gameLogTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.game_log_template')]));
        }

        return $this->view('backend.game_log_templates.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.game_log_template')]),
            'gameLogTemplate' => $gameLogTemplate,
            'types' => $this->modelClass::TYPES,
        ]);
    }

    public function update(Request $request, $id)
    {
        $gameLogTemplate = $this->modelClass::find($id);
        if (!$gameLogTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.game_log_template')]));
        }

        $gameLogTemplate->update([
            'type' => $request->type,
            'key' => $request->key,
            'remark' => $request->remark,
            'content' => $request->content,
        ]);

        $this->flush();

        return redirect()->route('game_log_templates.edit', ['id' => $gameLogTemplate->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
