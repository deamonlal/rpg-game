<?php

use App\Http\Controllers\CharacterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\InventoryController;

Route::get('/', [GameController::class, 'index'])->name('game');
Route::get('/fight', [GameController::class, 'fight']);
Route::get('/punch', [GameController::class, 'punch']);
Route::get('/leaveFight', [GameController::class, 'leaveFight']);
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
Route::get('/buy/{item}', [InventoryController::class, 'buyItem']);

Route::resource('characters', CharacterController::class);
