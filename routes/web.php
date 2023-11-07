<?php

use Illuminate\Support\Facades\Route;

$namespace = "IBoot\CMS\Http\Controllers";
$prefix = config('core.route_prefix', 'cms');

Route::namespace($namespace)->prefix($prefix)->middleware(['web', 'auth'])->group(function() {
    Route::resource('categories', 'CategoryController')->except(['show', 'store']);
    Route::post('categories/{id}/editable', 'CategoryController@editable')->name('categories.editable');
    Route::resource('posts', 'PostController');
});
