<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wncms\Http\Controllers\Backend\BackendController;

class ItemTemplateController extends BackendController
{
    protected array $cacheTags = ['item_templates'];

    public function index(Request $request)
    {
        $itemTemplates = $this->modelClass::query()
            ->orderBy('id', 'desc')
            ->get();

        return $this->view('backend.item_templates.index', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.item_template')]),
            'itemTemplates' => $itemTemplates,
        ]);
    }

    public function create($id = null)
    {
        $itemTemplate = $id
            ? $this->modelClass::find($id)
            : new $this->modelClass;

        if ($id && !$itemTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.item_template')]));
        }

        $item_options = $this->modelClass::orderBy('type', 'asc')->get();

        return $this->view('backend.item_templates.create', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.item_template')]),
            'itemTemplate' => $itemTemplate,
            'item_options' => $item_options,
            'types' => $this->modelClass::TYPES,
            'slots' => $this->modelClass::SLOTS,
        ]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $item_values = [];
        foreach ($request->item_key_values ?? [] as $row) {
            if (!empty($row['key']) && !empty($row['value'])) {
                $item_values[$row['key']] = $row['value'];
            }
        }

        $itemTemplate = $this->modelClass::create([
            'status' => $request->status ?? 'active',
            'slug' => $request->slug ?? wncms()->getUniqueSlug('item_templates'),
            'type' => $request->type,
            'slot' => $request->slot,
            'name' => $request->name,
            'description' => $request->description,
            'value' => $item_values,
            'is_stackable' => $request->is_stackable,
            'remark' => $request->remark,
        ]);

        if ($request->hasFile('item_template_thumbnail')) {
            $itemTemplate->addMediaFromRequest('item_template_thumbnail')
                ->toMediaCollection('item_template_thumbnail');
        }

        $itemTemplate->syncTagsFromTagify(
            $request->item_template_locations,
            'item_template_location'
        );

        $this->flush();

        return redirect()->route('item_templates.edit', ['id' => $itemTemplate->id])
            ->withMessage(__('wncms::word.successfully_created'));
    }

    public function edit($id)
    {
        $itemTemplate = $this->modelClass::find($id);
        if (!$itemTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.item_template')]));
        }

        $item_options = $this->modelClass::orderBy('type', 'asc')->get();

        return $this->view('backend.item_templates.edit', [
            'page_title' => __('wncms::word.model_management', ['model_name' => __('wncms::word.item_template')]),
            'itemTemplate' => $itemTemplate,
            'item_options' => $item_options,
            'types' => $this->modelClass::TYPES,
            'slots' => $this->modelClass::SLOTS,
        ]);
    }

    public function update(Request $request, $id)
    {
        $itemTemplate = $this->modelClass::find($id);
        if (!$itemTemplate) {
            return back()->withMessage(__('wncms::word.model_not_found', ['model_name' => __('wncms::word.item_template')]));
        }

        $item_values = [];
        foreach ($request->item_key_values ?? [] as $row) {
            if (!empty($row['key']) && !empty($row['value'])) {
                $item_values[$row['key']] = $row['value'];
            }
        }

        $itemTemplate->update([
            'status' => $request->status ?? 'active',
            'slug' => $request->slug,
            'type' => $request->type,
            'slot' => $request->slot,
            'name' => $request->name,
            'description' => $request->description,
            'value' => $item_values,
            'is_stackable' => $request->is_stackable,
            'remark' => $request->remark,
        ]);

        if ($request->hasFile('item_template_thumbnail')) {
            $itemTemplate->addMediaFromRequest('item_template_thumbnail')
                ->toMediaCollection('item_template_thumbnail');
        }

        $itemTemplate->syncTagsFromTagify(
            $request->item_template_locations,
            'item_template_location'
        );

        $this->flush();

        return redirect()->route('item_templates.edit', ['id' => $itemTemplate->id])
            ->withMessage(__('wncms::word.successfully_updated'));
    }
}
