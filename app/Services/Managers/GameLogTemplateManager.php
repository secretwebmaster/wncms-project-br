<?php

namespace App\Services\Managers;

use App\Models\GameLogTemplate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class GameLogTemplateManager
{
    public function save(array $data): GameLogTemplate
    {
        return DB::transaction(function () use ($data) {

            $template = GameLogTemplate::updateOrCreate(
                ['id' => $data['id'] ?? null],
                Arr::only($data, ['type', 'key', 'content', 'remark'])
            );

            $this->syncVariants($template, $data['variants'] ?? []);

            return $template;
        });
    }

    protected function syncVariants(GameLogTemplate $template, array $variants): void
    {
        $ids = [];

        foreach ($variants as $variantData) {

            $variantData['is_active'] = !empty($variantData['is_active']) ? 1 : 0;

            $conditions = $this->normalizeConditionTree($variantData['conditions'] ?? null);

            $variant = $template->variants()->updateOrCreate(
                [
                    'id' => $variantData['id'] ?? null,
                    'game_log_template_id' => $template->id,
                ],
                [
                    'variant_key' => $variantData['variant_key'] ?? null,
                    'priority' => (int) ($variantData['priority'] ?? 0),
                    'is_active' => $variantData['is_active'],
                    'content' => $variantData['content'] ?? '',
                    'conditions' => $conditions,
                    'remark' => $variantData['remark'] ?? null,
                ]
            );

            $ids[] = $variant->id;
        }

        $template->variants()->whereNotIn('id', $ids)->delete();
    }

    /**
     * Normalize recursive condition tree.
     */
    protected function normalizeConditionTree(mixed $node): ?array
    {
        if (!is_array($node)) {
            return null;
        }

        // GROUP NODE
        if (isset($node['type'], $node['children']) && is_array($node['children'])) {

            if (!in_array($node['type'], ['and', 'or'], true)) {
                return null;
            }

            $children = [];

            foreach ($node['children'] as $child) {
                $normalized = $this->normalizeConditionTree($child);
                if ($normalized !== null) {
                    $children[] = $normalized;
                }
            }

            // Empty group → discard
            if (empty($children)) {
                return null;
            }

            return [
                'type' => $node['type'],
                'children' => array_values($children),
            ];
        }

        // RULE NODE
        if (isset($node['field'])) {
            $field = trim((string) ($node['field'] ?? ''));
            if ($field === '') {
                return null;
            }

            return [
                'field' => $field,
                'operator' => (string) ($node['operator'] ?? '='),
                'value' => $node['value'] ?? null,
            ];
        }

        return null;
    }
}
