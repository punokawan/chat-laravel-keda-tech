<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\passportAuthController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ReportController;
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

Route::group(['prefix' => 'auth'], function () {
    // Route::post('register', 'AuthController@register');
    Route::post('login',[passportAuthController::class,'login']);
    Route::group(['middleware' => 'auth:api'], function () { 
        Route::post('logout',[passportAuthController::class,'logout']);
    });
    // Route::get('userList','AuthController@getUserList');
});

Route::group(['middleware' => 'auth:api'], function () {
    Route::group(['prefix' => 'message'], function () { 
        Route::middleware(['scope:Customer'])->get('user/{query}', [MessageController::class, 'user']);
        Route::get('user-message/{id}', [MessageController::class, 'message']);
        Route::get('user-message/{id}/read', [MessageController::class, 'read']);
        Route::post('user-message', [MessageController::class, 'send']);
    });
    
    Route::group(['prefix' => 'report'], function () { 
        Route::post('/', [ReportController::class, 'send']);
    });
});