<?php

use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

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


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('login');
    Route::post('register', 'register');
    Route::post('forgotPassword','forgotPassword');
    Route::post('resetpassword','resetpassword')->name('password.reset');
    Route::middleware('auth:api')->group(function (){
        Route::post('logout', 'logout');
        Route::post('refresh', 'refresh');
        Route::group(['controller' => CategoryController::class ,'prefix' => 'categories'], function () {
            Route::get('', 'index')->middleware(['permission:view category']);
            Route::post('', 'store')->middleware(['permission:add category']);
            Route::get('/{category}', 'show')->middleware(['permission:view category']);
            Route::put('/{category}', 'update')->middleware(['permission:edit category']);
            Route::delete('/{category}', 'destroy')->middleware(['permission:delete category']);
        });
        Route::group(['controller' => ProductController::class, 'prefix' => 'products'], function () {
            Route::post('', 'store')->middleware(['permission:add product']);
            Route::put('/{product}', 'update')->middleware(['permission:edit All products|edit own product']);
            Route::delete('/{product}', 'destroy')->middleware(['permission:delete All products|delete own product']);
        });
        Route::group(['controller' => UserController::class, 'prefix' => 'users'], function () {
            Route::get('', 'index')->middleware(['permission:view own profile|view all profiles']);
            Route::put('updateNameEmail/{user}', 'updateNameEmail')->middleware(['permission:edit own profile|edit all profiles']);
            Route::put('updatePassword/{user}', 'updatePassword')->middleware(['permission:edit own profile|edit all profiles']);
            Route::delete('/{user}', 'destroy')->middleware(['permission:delete own profile|delete all profiles']);
        });
    });
});


// Route::controller(ProductController::class)->group(function () {
//     Route::get('/products','index');
//     Route::get('/products/{product}','show');
//     Route::get('/products/filter/category/{filter}','filterCategory');
// });
