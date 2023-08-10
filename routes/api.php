<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('user.')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/user/info', [UserController::class, 'showUserInfo'])->name('info');
        Route::post('/auth/logout', [AuthController::class, 'logoutUser'])->name('logout');
    });

    Route::post('/auth/register', [AuthController::class, 'createUser'])->name('register');
    Route::post('/auth/login', [AuthController::class, 'loginUser'])->name('login');
});
