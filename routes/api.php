<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StoreController;

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

Route::name('auth.')->prefix('auth')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/logout', [AuthController::class, 'logoutUser'])->name('logout');
    });

    Route::post('/register', [AuthController::class, 'createUser'])->name('register');
    Route::post('/login', [AuthController::class, 'loginUser'])->name('login');
});


Route::name('user.')->prefix('user')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::post('/info', [UserController::class, 'showUserInfo'])->name('info');
    });
});

Route::name('store.')->prefix('store')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [StoreController::class, 'index'])->name('all');
        Route::post('/', [StoreController::class, 'store'])->name('add');
        Route::put('/{id}', [StoreController::class, 'update'])->name('update');
        Route::delete('/{id}', [StoreController::class, 'delete'])->name('delete');
    });
});
