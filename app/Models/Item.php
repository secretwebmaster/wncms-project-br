<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Wncms\Models\BaseModel;

class Item extends BaseModel
{
    public static $modelKey = 'item';

    protected $guarded = [];

    protected $casts = [
        'value' => 'array',
    ];

    public const ICONS = [
        'fontaweseom' => 'fa-solid fa-cube'
    ];

    public const ROUTES = [
        'index',
        'create',
    ];

    //!Scope
    public function scopeLocation(Builder $query, $x, $y): void
    {
        $query->where('x', $x)->where('y', $y);
    }

    public function item_template()
    {
        return $this->belongsTo(ItemTemplate::class);
    }

    public function player()
    {
        return $this->belongsTo(Player::class);
    }

    public function getEffectiveValue(): array
    {
        $templateValue = $this->item_template?->value ?? [];
        $itemValue = $this->value ?? [];

        // 確保都是 array
        if (!is_array($templateValue)) $templateValue = [];
        if (!is_array($itemValue)) $itemValue = [];

        // item.value 覆蓋 template.value
        $merged = array_merge($templateValue, $itemValue);

        // 只保留 numeric value
        return array_filter($merged, function ($v) {
            return is_numeric($v);
        });
    }

    public function getTooltipText(): string
    {
        $lines = [];

        $template = $this->item_template;

        // Item ID
        $lines[] = '#' . $this->id;

        // Description
        if (!empty($template?->description)) {
            $lines[] = strip_tags($template->description);
        }

        // Stats (generic)
        if (is_array($template?->value)) {
            foreach ($template->value as $key => $baseValue) {
                if ($baseValue === null || $baseValue === '') {
                    continue;
                }

                $value = $baseValue;

                // Level scaling (simple rule, adjust later if needed)
                if (is_numeric($value) && $this->level) {
                    $value += $this->level;
                }

                $lines[] = __('wncms::word.' . $key) . ': ' . $value;
            }
        }

        return implode("\n", $lines);
    }
}
