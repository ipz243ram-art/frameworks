<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoachController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/coaches', [CoachController::class, 'index']);
Route::get('/coaches/{id}', [CoachController::class, 'show']);
Route::post('/coaches', [CoachController::class, 'store']);
Route::patch('/coaches/{id}', [CoachController::class, 'update']);
Route::delete('/coaches/{id}', [CoachController::class, 'destroy']);
