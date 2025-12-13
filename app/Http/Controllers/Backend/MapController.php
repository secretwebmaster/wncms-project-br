<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class MapController extends BackendController
{
    protected array $cacheTags = ['maps'];

    public function index(Request $request)
    {
        $maps = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->get();

        return $this->view('backend.maps.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.map')]),
            'maps' => $maps,
        ]);
    }

    public function create($id = null)
    {
        $map = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$map) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.map')]));
        }

        return $this->view('backend.maps.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.map')]),
            'map' => $map,
        ]);
    }

    public function store(Request $request)
    {
        $map = $this->modelClass::create([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('maps.edit', ['id' => $map->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $map = $this->modelClass::find($id);
        if (!$map) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.map')]));
        }

        return $this->view('backend.maps.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.map')]),
            'map' => $map,
        ]);
    }

    public function update(Request $request, $id)
    {
        $map = $this->modelClass::find($id);
        if (!$map) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.map')]));
        }

        $map->update([
            'xxxx' => $request->xxxx,
        ]);

        $this->flush();

        return redirect()->route('maps.edit', ['id' => $map->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
