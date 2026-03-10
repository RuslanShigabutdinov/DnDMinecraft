<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{
    ClassController,
    CharacterController,
    FeatController,
};

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::get('/classes', [ClassController::class, 'list'])->name('classes.list');

    Route::post('/character', [CharacterController::class, 'store'])->name('characters.store');

    Route::get('/feats', [FeatController::class, 'list'])->name('feats.list');
});
