<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class SaveController extends BackendController
{
    protected array $cacheTags = ['saves'];

    public function index(Request $request)
    {
        $saves = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->get();

        return $this->view('backend.saves.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.save')]),
            'saves' => $saves,
        ]);
    }

    public function create($id = null)
    {
        $save = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$save) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.save')]));
        }

        return $this->view('backend.saves.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.save')]),
            'save' => $save,
        ]);
    }

    public function store(Request $request)
    {
        $save = $this->modelClass::create([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('saves.edit', ['id' => $save->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $save = $this->modelClass::find($id);
        if (!$save) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.save')]));
        }

        return $this->view('backend.saves.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.save')]),
            'save' => $save,
        ]);
    }

    public function update(Request $request, $id)
    {
        $save = $this->modelClass::find($id);
        if (!$save) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.save')]));
        }

        $save->update([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('saves.edit', ['id' => $save->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
