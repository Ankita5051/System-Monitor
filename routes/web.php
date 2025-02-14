<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MonitorController;
Route::get('/', function () {
    return view('welcome');
});

Route::fallback(function () {
    return response()->json([
        'message' => 'Invalid URL. Redirecting to home...',
        'status' => 404
    ], 404)->header('Location', url('/'));
});
