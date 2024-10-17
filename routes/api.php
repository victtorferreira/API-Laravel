<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/contacts', [ContactController::class, 'index']);
Route::middleware('auth:sanctum')->get('/contacts/{id}', [ContactController::class, 'showContact']);
Route::middleware('auth:sanctum')->post('/contacts', [ContactController::class, 'addContact']);
Route::middleware('auth:sanctum')->put('/contacts/{id}', [ContactController::class, 'editContact']);
Route::middleware('auth:sanctum')->delete('/contacts/{id}', [ContactController::class, 'deleteContact']);
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);



Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
