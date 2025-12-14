<?php

namespace App\Services\Managers;

use App\Models\Player;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class PlayerManager
{
    /**
     * Execute a player attack.
     *
     * @return array{
     *   damage:int,
     *   is_critical:bool,
     *   killed:bool,
     *   hp_before:int,
     *   hp_after:int
     * }
     */
    public function attack(Player $attacker, Player $defender, array $snapshot): array
    {
        if ($defender->status !== 'alive') {
            throw new InvalidArgumentException('Target is not alive');
        }

        return DB::transaction(function () use ($attacker, $defender) {

            // ===== base stats =====
            $basePower = (int) $attacker->final_str;
            $flatAtk   = (int) $attacker->final_atk;

            // random variance ±20%
            $variance = rand(-20, 20) / 100;

            // hp factor (low hp = weaker)
            $hpRatio  = $attacker->hp / max(1, $attacker->final_max_hp);
            $hpFactor = max(0.5, $hpRatio);

            // raw damage
            $rawDamage = ($basePower + $flatAtk) * (1 + $variance) * $hpFactor;

            // defense
            $defense = floor($defender->final_vit / 2) + (int) $defender->final_def;

            $damage = max(1, (int) ($rawDamage - $defense));

            // ===== critical hit =====
            // TEMP: force crit for testing
            // later: min(30, $attacker->final_luc * 2 + $attacker->final_crit)
            $critChance = 100;
            $isCrit = rand(1, 100) <= $critChance;
            info("Crit chance: $critChance%, rolled " . rand(1, 100) . ", isCrit: " . ($isCrit ? 'yes' : 'no'));

            if ($isCrit) {
                $damage = (int) ($damage * 2);
            }

            // ===== apply damage =====
            $hpBefore = (int) $defender->hp;
            $hpAfter  = max(0, $hpBefore - $damage);

            $defender->update([
                'hp'      => $hpAfter,
                'status'  => $hpAfter <= 0 ? 'dead' : 'alive',
                'died_at' => $hpAfter <= 0 ? now() : null,
            ]);

            if ($hpAfter <= 0) {
                $attacker->increment('kill');
            }

            return [
                'damage'      => $damage,
                'is_critical' => $isCrit,
                'killed'      => $hpAfter <= 0,
                'hp_before'   => $hpBefore,
                'hp_after'    => $hpAfter,
            ];
        });
    }
}
