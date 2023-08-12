<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StoreController;
use App\Http\Controllers\Api\ProductController;

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
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    });

    Route::post('/register', [AuthController::class, 'createUser'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
});

Route::name('store.')->prefix('store')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [StoreController::class, 'index'])->name('all');
        Route::get('/{id}', [StoreController::class, 'show'])->name('show');
        Route::post('/', [StoreController::class, 'store'])->name('add');
        Route::put('/{id}', [StoreController::class, 'update'])->name('update');
        Route::delete('/{id}', [StoreController::class, 'delete'])->name('delete');
    });
});

Route::name('product.')->prefix('product')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [ProductController::class, 'index'])->name('all');
        Route::get('/{id}', [ProductController::class, 'show'])->name('show');
        Route::post('/', [ProductController::class, 'store'])->name('add');
        Route::put('/{id}', [ProductController::class, 'update'])->name('update');
        Route::delete('/{id}', [ProductController::class, 'delete'])->name('delete');
    });
});
