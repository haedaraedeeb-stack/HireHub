<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\FreelancerProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);
Route::apiResource('/projects', ProjectController::class)->except('index');
});
Route::get('/projects' , [ProjectController::class, 'index']);

Route::prefix('freelancers')->group(function () {
    Route::get('/', [FreelancerController::class, 'index']);
    Route::get('/{freelancer}', [FreelancerController::class, 'show']);
});

Route::middleware(['auth:sanctum'])->group(function () {
    Route::prefix('profile/freelancer')->group(function () {
        Route::post('/', [FreelancerProfileController::class, 'store']);
        Route::post('update', [FreelancerProfileController::class, 'update']);
        Route::delete('/', [FreelancerProfileController::class, 'destroy']);
    });

});
