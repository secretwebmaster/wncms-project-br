<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class AchievementController extends BackendController
{
    protected array $cacheTags = ['achievements'];

    public function index(Request $request)
    {
        $achievements = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->get();

        return $this->view('backend.achievements.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.achievement')]),
            'achievements' => $achievements,
        ]);
    }

    public function create(int|string|null $id = null)
    {
        $achievement = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$achievement) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.achievement')]));
        }

        return $this->view('backend.achievements.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.achievement')]),
            'achievement' => $achievement,
        ]);
    }

    public function store(Request $request)
    {
        $achievement = $this->modelClass::create([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('achievements.edit', ['id' => $achievement->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $achievement = $this->modelClass::find($id);
        if (!$achievement) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.achievement')]));
        }

        return $this->view('backend.achievements.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.achievement')]),
            'achievement' => $achievement,
        ]);
    }

    public function update(Request $request, $id)
    {
        $achievement = $this->modelClass::find($id);
        if (!$achievement) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.achievement')]));
        }

        $achievement->update([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('achievements.edit', ['id' => $achievement->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
