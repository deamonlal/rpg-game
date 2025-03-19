<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ItemController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\InventoryController;


Route::get('/', [CharacterController::class, 'index']);
Route::get('/game', [GameController::class, 'index']);
Route::get('/fight', [GameController::class, 'fight']);
//Route::get('/punch', [GameController::class, 'punch']);
Route::get('/leaveFight', [GameController::class, 'leaveFight']);
Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
//Route::get('/buy/{item}', [InventoryController::class, 'buyItem']);

Route::resource('characters', CharacterController::class);
Route::resource('items', ItemController::class);
