<?php

use App\Http\Controllers\Blog\BlogController;
use App\Http\Controllers\Blog\BlogFeaturedController;
use App\Http\Controllers\Blog\BlogImageController;
use App\Http\Controllers\Blog\CategoryController;
use App\Http\Controllers\Blog\DashboardController;
use App\Http\Controllers\Blog\MultilanguageSettingController;
use App\Http\Controllers\Blog\TagController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

Route::group(['prefix' => 'blogs', 'as' => 'blog.'], function() {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('create', [BlogController::class, 'create'])->name('create');
    Route::post('store', [BlogController::class, 'store'])->name('store');
    Route::get('{blog}/edit', [BlogController::class, 'edit'])->name('edit');
    Route::patch('{blog}/update', [BlogController::class, 'update'])->name('update');
    Route::delete('{blog}/delete', [BlogController::class, 'delete'])->name('delete');

    Route::group(['prefix' => '{blog}/images', 'as' => 'image.'], function() {
        Route::get('/', [BlogImageController::class, 'index'])->name('index');
        Route::post('sort', [BlogImageController::class, 'sort'])->name('sort');
        Route::post('store', [BlogImageController::class, 'store'])->name('store');
        Route::patch('{blogImage}', [BlogImageController::class, 'update'])->name('update');
        Route::delete('{blogImage}', [BlogImageController::class, 'delete'])->name('delete');
    });
});

Route::group(['prefix' => 'blog-featureds', 'as' => 'blog-featured.'], function() {
    Route::get('/', [BlogFeaturedController::class, 'index'])->name('index');
    Route::get('search', [BlogFeaturedController::class, 'filter'])->name('filter');
    Route::post('sort', [BlogFeaturedController::class, 'sort'])->name('sort');
    Route::post('store', [BlogFeaturedController::class, 'store'])->name('store');
    Route::delete('{blog}/delete', [BlogFeaturedController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'tags', 'as' => 'tag.'], function() {
    Route::get('/', [TagController::class, 'index'])->name('index');
    Route::post('store', [TagController::class, 'store'])->name('store');
    Route::patch('{tag}/update', [TagController::class, 'update'])->name('update');
    Route::delete('{tag}/delete', [TagController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'categories', 'as' => 'category.'], function() {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::post('store', [CategoryController::class, 'store'])->name('store');
    Route::patch('{category}/update', [CategoryController::class, 'update'])->name('update');
    Route::delete('{category}/delete', [CategoryController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'language-setting', 'as' => 'language.setting.'], function() {
    Route::get('/', [MultilanguageSettingController::class, 'index'])->name('index');
    Route::get('search-language', [MultilanguageSettingController::class, 'searchLanguage'])->name('search-language');
    Route::post('store', [MultilanguageSettingController::class, 'store'])->name('store');
    Route::delete('{language}/delete', [MultilanguageSettingController::class, 'delete'])->name('delete');
});

Route::group(['prefix' => 'laravel-filemanager'], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

