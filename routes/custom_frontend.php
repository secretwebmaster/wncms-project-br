<?php

use App\Http\Controllers\Frontend\ItemController;
use App\Http\Controllers\Frontend\GameController;
use App\Http\Controllers\Frontend\PlayerController;

Route::prefix('game')->middleware(['prevent_go_back'])->group(function () {
    Route::get('home', [GameController::class, 'home'])->name('games.home');
});

Route::prefix('game')->middleware(['auth', 'prevent_go_back'])->group(function () {
    // Route::get('/', [GameController::class, 'start'])->name('frontend.pages.game');
    Route::post('start', [GameController::class, 'start'])->name('games.start');
    // Route::get('play', [GameController::class, 'play'])->name('games.play.new');
    Route::get('play/{game}', [GameController::class, 'play'])->name('games.play');

    Route::post('get_stage', [GameController::class, 'get_stage'])->name('games.get_stage');
    Route::post('create_game', [GameController::class, 'create_game'])->name('games.create_game');
    Route::post('get_create_game_progress', [GameController::class, 'get_create_game_progress'])->name('games.get_create_game_progress');
});

Route::prefix('player')->group(function () {
    Route::post('join', [PlayerController::class, 'join_game'])->name('players.join');
    Route::post('move', [PlayerController::class, 'move'])->name('players.move');
    Route::post('action', [PlayerController::class, 'action'])->name('players.action');
    Route::post('equip', [PlayerController::class, 'equip'])->name('players.equip');
    Route::post('unequip', [PlayerController::class, 'unequip'])->name('players.unequip');
    Route::post('eat', [PlayerController::class, 'eat'])->name('players.eat');

    Route::get('profile/{id}', [PlayerController::class, 'editProfile'])->name('players.profile');
    Route::post('profile/{id}', [PlayerController::class, 'updateProfile'])->name('players.profile.update');
});

Route::prefix('item')->group(function () {
    Route::post('combine', [ItemController::class, 'combine'])->name('items.combine');
    Route::post('upgrade', [ItemController::class, 'upgrade'])->name('items.upgrade');
});
