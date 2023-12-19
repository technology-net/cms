<?php

use Illuminate\Support\Facades\Route;
use IBoot\Core\App\Http\Middleware\Authenticate;

$namespace = "IBoot\CMS\Http\Controllers";
$prefix = config('core.route_prefix', 'cms');

Route::namespace($namespace)->prefix($prefix)->middleware(['web', Authenticate::class])->group(function() {
    Route::resource('categories', 'CategoryController')->except(['show', 'store']);
    Route::post('categories/{id}/editable', 'CategoryController@editable')->name('categories.editable');
    Route::post('categories/delete-all', 'CategoryController@deleteAll')->name('categories.deleteAll');
    Route::resource('posts', 'PostController')->except(['show', 'store']);
    Route::post('posts/{id}/editable', 'PostController@editable')->name('posts.editable');
    Route::post('posts/delete-all', 'PostController@deleteAll')->name('posts.deleteAll');
    Route::resource('pages', 'PageController')->except(['show', 'store']);
    Route::post('pages/{id}/editable', 'PageController@editable')->name('pages.editable');
    Route::post('pages/delete-all', 'PageController@deleteAll')->name('pages.deleteAll');
});
