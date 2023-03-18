<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExpertController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('users', [UserController::class, 'store'])->name('users.store');

Route::middleware(['auth:sanctum'])->group(function (){
    Route::get('logout', [AuthController::class, 'logout']);
    Route::get('users', [UserController::class, 'index'])->name('users.index');
    Route::get('user/{id}', [UserController::class, 'show'])->name('user.show');
    Route::put('user/{id}', [UserController::class, 'update'])->name('user.update');
    Route::delete('user/{id}', [UserController::class, 'destroy'])->name('user.destroy');
    Route::apiResource('experts', ExpertController::class);
    Route::apiResource('registers', RegisterController::class);
});