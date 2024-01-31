<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/{any}', function () {
    // Get the path from the request
    $path = request()->path();
    // Check the path and return the corresponding view
    if ($path === '/') {
        return view('app');
    } elseif (strpos($path, 'admin') !== false) {
        return view('admin.app');
    }
})->where('any', '.*');
