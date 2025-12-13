<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class MonsterTemplateController extends BackendController
{
    protected array $cacheTags = ['monster_templates'];

    public function index(Request $request)
    {
        $monsterTemplates = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->get();

        return $this->view('backend.monster_templates.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.monster_template')]),
            'monsterTemplates' => $monsterTemplates,
        ]);
    }

    public function create($id = null)
    {
        $monsterTemplate = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$monsterTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.monster_template')]));
        }

        return $this->view('backend.monster_templates.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.monster_template')]),
            'monsterTemplate' => $monsterTemplate,
        ]);
    }

    public function store(Request $request)
    {
        $monsterTemplate = $this->modelClass::create([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('monster_templates.edit', ['id' => $monsterTemplate->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $monsterTemplate = $this->modelClass::find($id);
        if (!$monsterTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.monster_template')]));
        }

        return $this->view('backend.monster_templates.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.monster_template')]),
            'monsterTemplate' => $monsterTemplate,
        ]);
    }

    public function update(Request $request, $id)
    {
        $monsterTemplate = $this->modelClass::find($id);
        if (!$monsterTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.monster_template')]));
        }

        $monsterTemplate->update([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('monster_templates.edit', ['id' => $monsterTemplate->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
