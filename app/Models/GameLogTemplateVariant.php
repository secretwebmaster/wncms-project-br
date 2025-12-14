<?php

namespace App\Models;

use Wncms\Models\BaseModel;
use Wncms\Translatable\Traits\HasTranslations;

class GameLogTemplateVariant extends BaseModel
{
    use HasTranslations;

    public static $modelKey = 'game_log_template_variant';

    protected $guarded = [];

    protected $casts = [
        'conditions' => 'array',
        'is_active' => 'boolean',
    ];

    protected $translatable = ['content'];

    public const OPERATORS = [
        '='  => '=',
        '!=' => '≠',
        '>'  => '>',
        '>=' => '≥',
        '<'  => '<',
        '<=' => '≤',
        'in' => 'IN',
        'not_in' => 'NOT IN',
    ];

    public function game_log_template()
    {
        return $this->belongsTo(GameLogTemplate::class);
    }

    public function matches(array $data): bool
    {
        if (empty($this->is_active)) return false;

        $conditions = $this->conditions ?? ['and' => [], 'or' => []];

        if (is_array($conditions) && array_is_list($conditions)) {
            $conditions = ['and' => $conditions, 'or' => []];
        }

        $and = $conditions['and'] ?? [];
        $or = $conditions['or'] ?? [];

        if (!empty($and)) {
            foreach ($and as $cond) {
                if (!$this->evalCondition($cond, $data)) return false;
            }
        }

        if (!empty($or)) {
            $ok = false;
            foreach ($or as $cond) {
                if ($this->evalCondition($cond, $data)) {
                    $ok = true;
                    break;
                }
            }
            if (!$ok) return false;
        }

        return true;
    }

    protected function evalCondition(array $cond, array $data): bool
    {
        $field = (string) ($cond['field'] ?? '');
        $op = (string) ($cond['operator'] ?? '=');
        $expected = $cond['value'] ?? null;

        $actual = data_get($data, $field);

        return match ($op) {
            '=' => (string) $actual == (string) $expected,
            '!=' => (string) $actual != (string) $expected,
            '>' => is_numeric($actual) && is_numeric($expected) && $actual > $expected,
            '<' => is_numeric($actual) && is_numeric($expected) && $actual < $expected,
            '>=' => is_numeric($actual) && is_numeric($expected) && $actual >= $expected,
            '<=' => is_numeric($actual) && is_numeric($expected) && $actual <= $expected,
            'contains' => is_string($actual) && is_string($expected) && str_contains($actual, $expected),
            'not_contains' => is_string($actual) && is_string($expected) && !str_contains($actual, $expected),
            'in' => $this->opIn($actual, $expected),
            'not_in' => !$this->opIn($actual, $expected),
            'exists' => !is_null($actual) && $actual !== '',
            'not_exists' => is_null($actual) || $actual === '',
            default => (string) $actual == (string) $expected,
        };
    }

    protected function opIn(mixed $actual, mixed $expected): bool
    {
        if (is_array($expected)) {
            return in_array($actual, $expected, false);
        }

        // Support CSV in UI: "a,b,c"
        if (is_string($expected)) {
            $list = array_values(array_filter(array_map('trim', explode(',', $expected)), fn($v) => $v !== ''));
            return in_array((string) $actual, array_map('strval', $list), true);
        }

        return false;
    }
}
