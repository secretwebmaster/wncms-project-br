<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class BattleController extends BackendController
{
    protected array $cacheTags = ['battles'];

    public function index(Request $request)
    {
        $battles = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->get();

        return $this->view('backend.battles.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.battle')]),
            'battles' => $battles,
        ]);
    }

    public function create(int|string|null $id = null)
    {
        $battle = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$battle) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.battle')]));
        }

        return $this->view('backend.battles.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.battle')]),
            'battle' => $battle,
        ]);
    }

    public function store(Request $request)
    {
        $battle = $this->modelClass::create([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('battles.edit', ['id' => $battle->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $battle = $this->modelClass::find($id);
        if (!$battle) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.battle')]));
        }

        return $this->view('backend.battles.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.battle')]),
            'battle' => $battle,
        ]);
    }

    public function update(Request $request, $id)
    {
        $battle = $this->modelClass::find($id);
        if (!$battle) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.battle')]));
        }

        $battle->update([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('battles.edit', ['id' => $battle->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
