<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('register', [AuthController::class, 'register']);
    Route::post('registerAdmin', [AuthController::class, 'registerAdmin']);
    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('logout',  [AuthController::class, 'logout']);
    });
    Route::group([
      'middleware' => ['auth:api', 'scope:admin']
    ], function() {
        Route::get('user',  [AuthController::class, 'user']);
    });
    Route::group([
      'middleware' => ['auth:api', 'scope:user']
    ], function() {
        Route::get('test',  [AuthController::class, 'test']);
    });

});
