<?php

use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\TagController;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'blogs'], function() {
    Route::get('/', [BlogController::class, 'index']);
    Route::get('featured', [BlogController::class, 'featured']);
    Route::get('{blog}', [BlogController::class, 'detail']);
});

Route::group(['prefix' => 'categories'], function() {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('{category}', [CategoryController::class, 'detail']);
});

Route::group(['prefix' => 'tags'], function() {
    Route::get('/', [TagController::class, 'index']);
    Route::get('{tag}', [TagController::class, 'detail']);
});