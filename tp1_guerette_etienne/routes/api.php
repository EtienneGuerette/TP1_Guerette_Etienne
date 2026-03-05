<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\RentalController;

Route::get('/equipment', [EquipmentController::class, 'index']);
Route::get('/equipment/{id}', [EquipmentController::class, 'show']);

Route::get('/equipment/{id}/popularity', [EquipmentController::class, 'popularity']);

Route::post('/users', [UserController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'update']);

Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

Route::get('/rentals/{id}/average_price', [RentalController::class, 'averagePrice']);
