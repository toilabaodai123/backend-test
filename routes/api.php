<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

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
    Route::middleware(['auth:sanctum'])->group(function(){
        Route::get('/user',[UserController::class,'showUserInfo'])->name('info');
        Route::post('/auth/logout', [UserController::class, 'logoutUser'])->name('logout');
    });
    
    Route::post('/auth/register', [UserController::class, 'createUser'])->name('register');
    Route::post('/auth/login', [UserController::class, 'loginUser'])->name('login');
});
