<?php

use App\Http\Controllers\Api\V1\Admin\SpinHistoryController;
use App\Http\Controllers\Api\V1\SpinController;
use Illuminate\Support\Facades\Route;


Route::middleware(['auth:sanctum', 'role:Retailer', 'throttle:api'])->group(function () {
    Route::post('spin', [SpinController::class, 'useSpin'])->name('spin'); 
    Route::post('buy-spin', [SpinController::class, 'buySpin'])->name('spin.buy');
    Route::get('spin-history', [SpinController::class, 'getUserSpinHistory'])->name('spin.history');
});


Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/spin-history', SpinHistoryController::class);
});

