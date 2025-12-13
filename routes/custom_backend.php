<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Backend\AchievementController;
use App\Http\Controllers\Backend\BattleController;
use App\Http\Controllers\Backend\GameController;
use App\Http\Controllers\Backend\GameLogController;
use App\Http\Controllers\Backend\GameLogTemplateController;
use App\Http\Controllers\Backend\ItemController;
use App\Http\Controllers\Backend\ItemTemplateController;
use App\Http\Controllers\Backend\MapController;
use App\Http\Controllers\Backend\MonsterController;
use App\Http\Controllers\Backend\MonsterTemplateController;
use App\Http\Controllers\Backend\PlayerController;
use App\Http\Controllers\Backend\PlayerActionController;
use App\Http\Controllers\Backend\SaveController;

/*
|--------------------------------------------------------------------------
| Game
|--------------------------------------------------------------------------
*/
Route::prefix('games')->controller(GameController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:game_index')->name('games.index');
    Route::get('create', 'create')->middleware('can:game_create')->name('games.create');
    Route::get('create/{id}', 'create')->middleware('can:game_clone')->name('games.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:game_edit')->name('games.edit');
    Route::post('store', 'store')->middleware('can:game_create')->name('games.store');
    Route::patch('{id}', 'update')->middleware('can:game_edit')->name('games.update');
    Route::delete('{id}', 'destroy')->middleware('can:game_delete')->name('games.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:game_bulk_delete')->name('games.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Player
|--------------------------------------------------------------------------
*/
Route::prefix('players')->controller(PlayerController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:player_index')->name('players.index');
    Route::get('create', 'create')->middleware('can:player_create')->name('players.create');
    Route::get('create/{id}', 'create')->middleware('can:player_clone')->name('players.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:player_edit')->name('players.edit');
    Route::post('store', 'store')->middleware('can:player_create')->name('players.store');
    Route::patch('{id}', 'update')->middleware('can:player_edit')->name('players.update');
    Route::delete('{id}', 'destroy')->middleware('can:player_delete')->name('players.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:player_bulk_delete')->name('players.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Achievement
|--------------------------------------------------------------------------
*/
Route::prefix('achievements')->controller(AchievementController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:achievement_index')->name('achievements.index');
    Route::get('create', 'create')->middleware('can:achievement_create')->name('achievements.create');
    Route::get('create/{id}', 'create')->middleware('can:achievement_clone')->name('achievements.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:achievement_edit')->name('achievements.edit');
    Route::post('store', 'store')->middleware('can:achievement_create')->name('achievements.store');
    Route::patch('{id}', 'update')->middleware('can:achievement_edit')->name('achievements.update');
    Route::delete('{id}', 'destroy')->middleware('can:achievement_delete')->name('achievements.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:achievement_bulk_delete')->name('achievements.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Battle
|--------------------------------------------------------------------------
*/
Route::prefix('battles')->controller(BattleController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:battle_index')->name('battles.index');
    Route::get('create', 'create')->middleware('can:battle_create')->name('battles.create');
    Route::get('create/{id}', 'create')->middleware('can:battle_clone')->name('battles.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:battle_edit')->name('battles.edit');
    Route::post('store', 'store')->middleware('can:battle_create')->name('battles.store');
    Route::patch('{id}', 'update')->middleware('can:battle_edit')->name('battles.update');
    Route::delete('{id}', 'destroy')->middleware('can:battle_delete')->name('battles.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:battle_bulk_delete')->name('battles.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Item Template
|--------------------------------------------------------------------------
*/
Route::prefix('item_templates')->controller(ItemTemplateController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:item_template_index')->name('item_templates.index');
    Route::get('create', 'create')->middleware('can:item_template_create')->name('item_templates.create');
    Route::get('create/{id}', 'create')->middleware('can:item_template_clone')->name('item_templates.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:item_template_edit')->name('item_templates.edit');
    Route::post('store', 'store')->middleware('can:item_template_create')->name('item_templates.store');
    Route::patch('{id}', 'update')->middleware('can:item_template_edit')->name('item_templates.update');
    Route::delete('{id}', 'destroy')->middleware('can:item_template_delete')->name('item_templates.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:item_template_bulk_delete')->name('item_templates.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Item
|--------------------------------------------------------------------------
*/
Route::prefix('items')->controller(ItemController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:item_index')->name('items.index');
    Route::get('create', 'create')->middleware('can:item_create')->name('items.create');
    Route::get('create/{id}', 'create')->middleware('can:item_clone')->name('items.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:item_edit')->name('items.edit');
    Route::post('store', 'store')->middleware('can:item_create')->name('items.store');
    Route::patch('{id}', 'update')->middleware('can:item_edit')->name('items.update');
    Route::delete('{id}', 'destroy')->middleware('can:item_delete')->name('items.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:item_bulk_delete')->name('items.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Game Log Template
|--------------------------------------------------------------------------
*/
Route::prefix('game_log_templates')->controller(GameLogTemplateController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:game_log_template_index')->name('game_log_templates.index');
    Route::get('create', 'create')->middleware('can:game_log_template_create')->name('game_log_templates.create');
    Route::get('create/{id}', 'create')->middleware('can:game_log_template_clone')->name('game_log_templates.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:game_log_template_edit')->name('game_log_templates.edit');
    Route::post('store', 'store')->middleware('can:game_log_template_create')->name('game_log_templates.store');
    Route::patch('{id}', 'update')->middleware('can:game_log_template_edit')->name('game_log_templates.update');
    Route::delete('{id}', 'destroy')->middleware('can:game_log_template_delete')->name('game_log_templates.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:game_log_template_bulk_delete')->name('game_log_templates.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Game Log
|--------------------------------------------------------------------------
*/
Route::prefix('game_logs')->controller(GameLogController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:game_log_index')->name('game_logs.index');
    Route::get('create', 'create')->middleware('can:game_log_create')->name('game_logs.create');
    Route::get('create/{id}', 'create')->middleware('can:game_log_clone')->name('game_logs.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:game_log_edit')->name('game_logs.edit');
    Route::post('store', 'store')->middleware('can:game_log_create')->name('game_logs.store');
    Route::patch('{id}', 'update')->middleware('can:game_log_edit')->name('game_logs.update');
    Route::delete('{id}', 'destroy')->middleware('can:game_log_delete')->name('game_logs.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:game_log_bulk_delete')->name('game_logs.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Map
|--------------------------------------------------------------------------
*/
Route::prefix('maps')->controller(MapController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:map_index')->name('maps.index');
    Route::get('create', 'create')->middleware('can:map_create')->name('maps.create');
    Route::get('create/{id}', 'create')->middleware('can:map_clone')->name('maps.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:map_edit')->name('maps.edit');
    Route::post('store', 'store')->middleware('can:map_create')->name('maps.store');
    Route::patch('{id}', 'update')->middleware('can:map_edit')->name('maps.update');
    Route::delete('{id}', 'destroy')->middleware('can:map_delete')->name('maps.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:map_bulk_delete')->name('maps.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Monster
|--------------------------------------------------------------------------
*/
Route::prefix('monsters')->controller(MonsterController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:monster_index')->name('monsters.index');
    Route::get('create', 'create')->middleware('can:monster_create')->name('monsters.create');
    Route::get('create/{id}', 'create')->middleware('can:monster_clone')->name('monsters.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:monster_edit')->name('monsters.edit');
    Route::post('store', 'store')->middleware('can:monster_create')->name('monsters.store');
    Route::patch('{id}', 'update')->middleware('can:monster_edit')->name('monsters.update');
    Route::delete('{id}', 'destroy')->middleware('can:monster_delete')->name('monsters.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:monster_bulk_delete')->name('monsters.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Monster Template
|--------------------------------------------------------------------------
*/
Route::prefix('monster_templates')->controller(MonsterTemplateController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:monster_template_index')->name('monster_templates.index');
    Route::get('create', 'create')->middleware('can:monster_template_create')->name('monster_templates.create');
    Route::get('create/{id}', 'create')->middleware('can:monster_template_clone')->name('monster_templates.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:monster_template_edit')->name('monster_templates.edit');
    Route::post('store', 'store')->middleware('can:monster_template_create')->name('monster_templates.store');
    Route::patch('{id}', 'update')->middleware('can:monster_template_edit')->name('monster_templates.update');
    Route::delete('{id}', 'destroy')->middleware('can:monster_template_delete')->name('monster_templates.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:monster_template_bulk_delete')->name('monster_templates.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Player Action
|--------------------------------------------------------------------------
*/
Route::prefix('player_actions')->controller(PlayerActionController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:player_action_index')->name('player_actions.index');
    Route::get('create', 'create')->middleware('can:player_action_create')->name('player_actions.create');
    Route::get('create/{id}', 'create')->middleware('can:player_action_clone')->name('player_actions.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:player_action_edit')->name('player_actions.edit');
    Route::post('store', 'store')->middleware('can:player_action_create')->name('player_actions.store');
    Route::patch('{id}', 'update')->middleware('can:player_action_edit')->name('player_actions.update');
    Route::delete('{id}', 'destroy')->middleware('can:player_action_delete')->name('player_actions.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:player_action_bulk_delete')->name('player_actions.bulk_delete');
});

/*
|--------------------------------------------------------------------------
| Save
|--------------------------------------------------------------------------
*/
Route::prefix('saves')->controller(SaveController::class)->group(function () {
    Route::get('/', 'index')->middleware('can:save_index')->name('saves.index');
    Route::get('create', 'create')->middleware('can:save_create')->name('saves.create');
    Route::get('create/{id}', 'create')->middleware('can:save_clone')->name('saves.clone');
    Route::get('{id}/edit', 'edit')->middleware('can:save_edit')->name('saves.edit');
    Route::post('store', 'store')->middleware('can:save_create')->name('saves.store');
    Route::patch('{id}', 'update')->middleware('can:save_edit')->name('saves.update');
    Route::delete('{id}', 'destroy')->middleware('can:save_delete')->name('saves.destroy');
    Route::post('bulk_delete', 'bulk_delete')->middleware('can:save_bulk_delete')->name('saves.bulk_delete');
});
