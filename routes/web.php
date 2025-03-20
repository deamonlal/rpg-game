<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TraderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\InventoryController;


Route::get('/', [CharacterController::class, 'index']);
Route::get('/game', [GameController::class, 'index']);
Route::get('/fight', [GameController::class, 'fight']);
Route::get('/leaveFight', [GameController::class, 'leaveFight']);

Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');

Route::get('/trader', [TraderController::class, 'index'])->name('trader');
Route::post('/trader/buy/{item}', [TraderController::class, 'buy'])->name('trader.buy');
Route::post('/trader/sell/{item}', [TraderController::class, 'sell'])->name('trader.sell');

Route::get('equipment', [EquipmentController::class, 'index'])->name('equipment');
Route::post('equipment', [EquipmentController::class, 'store'])->name('equipment.store');
Route::delete('equipment', [EquipmentController::class, 'destroy'])->name('equipment.destroy');

Route::resource('characters', CharacterController::class);
Route::resource('items', ItemController::class);
