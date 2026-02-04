<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SensorController;
use App\Http\Controllers\EnvironmentController;

Route::post("register", [AuthController::class, "register"]);
Route::post("login", [AuthController::class, "login"]);

Route::middleware('auth:api')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('logout', [AuthController::class, 'logout']);

    // Sensor Data Routes
    Route::get('sensor/history', [SensorController::class, 'history']);
    Route::get('sensor/realtime', [SensorController::class, 'realtime']);
    Route::post('sensor/data', [SensorController::class, 'store']);

    Route::post('select-plan', [EnvironmentController::class, 'selectPlan']);
    Route::put('update-settings', [EnvironmentController::class, 'updateSettings']);
    Route::get('settings', [EnvironmentController::class, 'getSettings']);

    Route::get('devices', function () {
    return \App\Models\Device::whereHas('plant', function($q) {
        $q->where('user_id', auth()->id());
    })->get();
});

});