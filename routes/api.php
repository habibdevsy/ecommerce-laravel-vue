<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
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
        Route::resource('brand', BrandController::class);
        Route::resource('product', ProductController::class);
        Route::get('productsOfCategory/{category_id}', [ProductController::class, 'productsOfCategory']);
        Route::get('productsBest', [ProductController::class, 'productsBest']);
    });
});

Route::group([
    'prefix' => 'user'
],function() {

        Route::group([
            'prefix' => 'product'
          ], function() {
            Route::get('product/{id}', [ProductController::class, 'show']);
            Route::get('productsByCategory/{category_id}', [ProductController::class, 'productsOfCategory']);
            Route::get('productsByBrand/{brand_id}', [ProductController::class, 'productsOfBrand']);
            Route::get('productsBest', [ProductController::class, 'productsBest']);
              });

        Route::group([
            'prefix' => 'category'
          ], function() {
            Route::get('categories', [CategoryController::class, 'index']);
            Route::get('category/{id}', [CategoryController::class, 'show']);
            Route::get('categoriesWithProducts', [CategoryController::class, 'categoriesWithProducts']);
              });

        Route::group([
            'prefix' => 'brand'
          ], function() {
            Route::get('brands', [BrandController::class, 'index']);
            Route::get('brand/{id}', [BrandController::class, 'show']);
            Route::get('brandsWithProducts', [BrandController::class, 'brandsWithProducts']);
              });

        });
// for routes pay use ->middleware(['auth:api', 'scope:user'])
//for test with ionic without login
// Route::get('productsOfCategory/{category_id}', [ProductController::class, 'productsOfCategory']);
// Route::get('productsBest', [ProductController::class, 'productsBest']);
// Route::get('categories', [CategoryController::class, 'index'])->middleware(['auth:api', 'scope:user']);
