<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Models\User;
use App\Models\Category;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout',  [AuthController::class, 'logout']);
    });
});

Route::group([
    'prefix' => 'admin'
], function () {
    Route::post('registerAdmin', [AuthController::class, 'registerAdmin']);
    Route::group([
      'middleware' => ['auth:api', 'scope:admin']
    ], function() {
        Route::resource('category', CategoryController::class);
    });
});

Route::group([
    'prefix' => 'user'
], function () {
    Route::group([
      'middleware' => ['auth:api', 'scope:user']
    ], function() {
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('category/{id}', [CategoryController::class, 'show']);
    });
});
