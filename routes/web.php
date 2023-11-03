<?php

use Illuminate\Support\Facades\Route;

$namespace = "IBoot\CMS\Http\Controllers";
$prefix = config('app.route_prefix', 'cms');

Route::namespace($namespace)->prefix($prefix)->middleware(['web'])->group(function() {
    Route::resource('posts', 'PostController');
});
