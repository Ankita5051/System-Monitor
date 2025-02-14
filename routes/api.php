<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitorController;

Route::get('/metrics', [MonitorController::class, 'getMetrics']);
Route::post('/metadata', [MonitorController::class, 'setMetadata']);
Route::get('/metadata', [MonitorController::class, 'getMetadata']);
Route::get('/alerts', [MonitorController::class, 'getAlerts']);
Route::get('/metrics/history',[MonitorController::class, 'getAllMetrics']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/test', function () {
    return response()->json(['message' => 'API working']);
});