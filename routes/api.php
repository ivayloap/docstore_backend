<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/documents', [DocumentController::class, 'upload']);
    Route::get('/documents/{id}', [DocumentController::class, 'download']);
    Route::get('/documents', [DocumentController::class, 'index']);
});
