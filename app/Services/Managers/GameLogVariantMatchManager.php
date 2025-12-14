<?php

namespace App\Services\Managers;

use App\Models\GameLogTemplateVariant;
use Illuminate\Support\Collection;

class GameLogVariantMatchManager
{
    public function match(Collection $variants, array $data): GameLogTemplateVariant
    {
        $matched = $variants
            ->where('is_active', true)
            ->filter(fn($v) => $this->matchConditions($v->conditions ?? [], $data))
            ->sortByDesc('priority')
            ->first();

        return $matched;
    }

    protected function matchConditions(array $conditions, array $data): bool
    {
        if (empty($conditions)) {
            return true;
        }

        foreach ($conditions as $key => $rule) {
            if ($key === '$or') {
                if (!collect($rule)->contains(fn($c) => $this->matchConditions($c, $data))) {
                    return false;
                }
                continue;
            }

            if (!array_key_exists($key, $data)) {
                return false;
            }

            foreach ($rule as $op => $value) {
                if (!$this->compare($data[$key], $op, $value)) {
                    return false;
                }
            }
        }

        return true;
    }

    protected function compare($actual, string $op, $expected): bool
    {
        return match ($op) {
            '==' => $actual == $expected,
            '!=' => $actual != $expected,
            '>'  => $actual > $expected,
            '>=' => $actual >= $expected,
            '<'  => $actual < $expected,
            '<=' => $actual <= $expected,
            'in' => in_array($actual, (array) $expected, true),
            'not_in' => !in_array($actual, (array) $expected, true),
            default => false,
        };
    }
}
