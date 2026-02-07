<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PlantController;
use App\Http\Controllers\EnvironmentController;
use App\Http\Controllers\SensorController;

Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [AuthController::class, 'logout']);

    // Plant Management
    Route::apiResource('plants', PlantController::class);

    // Environment Settings
    Route::post('select-plan', [EnvironmentController::class, 'selectPlan']);
    Route::put('update-settings', [EnvironmentController::class, 'updateSettings']);
    Route::get('settings', [EnvironmentController::class, 'getSettings']);

    //sensor 
    Route::post('sensor/live', [SensorController::class, 'live']);
    Route::get('sensor/latest', [SensorController::class, 'latest']);
});