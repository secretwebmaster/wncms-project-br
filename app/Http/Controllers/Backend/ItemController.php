<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class ItemController extends BackendController
{
    protected array $cacheTags = ['items'];

    public function index(Request $request)
    {
        $items = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->get();

        return $this->view('backend.items.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.item')]),
            'items' => $items,
        ]);
    }

    public function create(int|string|null $id = null)
    {
        $item = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$item) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.item')]));
        }

        return $this->view('backend.items.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.item')]),
            'item' => $item,
        ]);
    }

    public function store(Request $request)
    {
        $item = $this->modelClass::create([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('items.edit', ['id' => $item->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $item = $this->modelClass::find($id);
        if (!$item) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.item')]));
        }

        return $this->view('backend.items.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.item')]),
            'item' => $item,
        ]);
    }

    public function update(Request $request, $id)
    {
        $item = $this->modelClass::find($id);
        if (!$item) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.item')]));
        }

        $item->update([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('items.edit', ['id' => $item->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
