<?php

namespace App\Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create permissions
        foreach([
            'achievement',
            'battle',
            'game',
            'game_log',
            'game_log_template',
            'item',
            'item_template',
            'map',
            'monster',
            'monster_template',
            'player',
            'player_action',
            'save',
        ] as $modelKey) {
            Artisan::call('wncms:create-model-permission', [
                'model_name' => $modelKey,
            ]);
        }

        // create game log templates
        DB::table('game_log_templates')->insert([
            [
                'type' => 'item',
                'key' => 'player_found_item',
                'content' => '[keyword m="player" mk="id" mv="name" dk="player_id" class="player-name"] 找到了 [keyword m="item" mk="id" mv="name" dk="item_id" class="item-name"]',
                'remark' => '用戶找到了物品',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'item',
                'key' => 'player_equipped_item',
                'content' => '[keyword m="player" mk="id" mv="name" dk="player_id" class="player-name"] 裝備了 [keyword m="item" mk="id" mv="name" dk="item_id" class="item-name"]',
                'remark' => '玩家裝備物品',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'item',
                'key' => 'player_unequipped_item',
                'content' => '[keyword m="player" mk="id" mv="name" dk="player_id" class="player-name"] 卸下了 [keyword m="item" mk="id" mv="name" dk="item_id" class="item-name"]',
                'remark' => '玩家卸下裝備',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'type' => 'battle',
                'key' => 'player_meet_player',
                'content' => '[keyword m="player" mk="id" mv="name" dk="player_id" class="player-name"] 遇到了 [keyword m="player" mk="id" mv="name" dk="other_player_id" class="player-name"]',
                'remark' => '玩家遇到玩家',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        // create item localtions

        // create item templates


        // create monster templates
    }
}
