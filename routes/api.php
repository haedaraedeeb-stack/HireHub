<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\FreelancerController;
use App\Http\Controllers\FreelancerProfileController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\DashboardController;
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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/offers', [OfferController::class, 'store'])
        ->middleware('verified_freelancer');
    Route::get('/offers/{offer}', [OfferController::class, 'show']);
    Route::patch('/offers/{offer}/status', [OfferController::class, 'updateStatus']);
    });

Route::middleware(['auth:sanctum', 'is_admin'])->group(function () {
        Route::get('/dashboard/stats', [DashboardController::class, 'index']);
});
