<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;
use App\Services\Managers\GameLogTemplateManager;
use App\Models\GameLogTemplate;
use App\Models\GameLogTemplateVariant;

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
            ? $this->modelClass::with('variants')->find($id)
            : new $this->modelClass;

        if ($id && !$gameLogTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.game_log_template')]));
        }

        return $this->view('backend.game_log_templates.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.game_log_template')]),
            'gameLogTemplate' => $gameLogTemplate,
            'types' => $this->modelClass::TYPES,
            'operators' => GameLogTemplateVariant::OPERATORS,
        ]);
    }

    public function store(Request $request)
    {
        $manager = app(GameLogTemplateManager::class);

        // check duplicate key 
        if ($this->modelClass::where('key', $request->key)->exists()) {
            return back()->withErrors([
                'message' => __('wncms::word.duplocate_template_is_found'),
            ]);
        }

        $template = $manager->save($request->all());

        $this->flush();

        return redirect()->route('game_log_templates.edit', ['id' => $template->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $gameLogTemplate = $this->modelClass::with('variants')->find($id);

        if (!$gameLogTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.game_log_template')]));
        }

        return $this->view('backend.game_log_templates.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.game_log_template')]),
            'gameLogTemplate' => $gameLogTemplate,
            'types' => $this->modelClass::TYPES,
            'operators' => GameLogTemplateVariant::OPERATORS,
        ]);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $manager = app(GameLogTemplateManager::class);

        $template = $this->modelClass::find($id);
        if (!$template) {
            return back()->withMessage(__('wncms::word.model_not_found', [
                'model_name' => __('wncms::word.game_log_template'),
            ]));
        }

        $manager->save(array_merge(
            $request->all(),
            ['id' => $template->id]
        ));

        $this->flush();

        return redirect()->route('game_log_templates.edit', ['id' => $template->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
