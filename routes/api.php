<?php

use App\Http\Controllers\QueueController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/add', [QueueController::class, 'addToQueue']);
Route::get('/get', [QueueController::class, 'getFromQueue']);
