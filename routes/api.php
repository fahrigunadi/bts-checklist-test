<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\LoginController;
use App\Http\Controllers\API\Auth\RegisterController;
use App\Http\Controllers\API\Checklist\ChecklistController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', LoginController::class);
Route::post('/register', RegisterController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(ChecklistController::class)->group(function () {
        Route::get('/checklist', 'index');
        Route::post('/checklist', 'store');
        Route::delete('/checklist/{checklist}', 'destroy');
    });
});
