<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class MonsterController extends BackendController
{
    protected array $cacheTags = ['monsters'];

    public function index(Request $request)
    {
        $monsters = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->get();

        return $this->view('backend.monsters.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.monster')]),
            'monsters' => $monsters,
        ]);
    }

    public function create($id = null)
    {
        $monster = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$monster) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.monster')]));
        }

        return $this->view('backend.monsters.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.monster')]),
            'monster' => $monster,
        ]);
    }

    public function store(Request $request)
    {
        $monster = $this->modelClass::create([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('monsters.edit', ['id' => $monster->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $monster = $this->modelClass::find($id);
        if (!$monster) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.monster')]));
        }

        return $this->view('backend.monsters.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.monster')]),
            'monster' => $monster,
        ]);
    }

    public function update(Request $request, $id)
    {
        $monster = $this->modelClass::find($id);
        if (!$monster) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.monster')]));
        }

        $monster->update([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('monsters.edit', ['id' => $monster->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
