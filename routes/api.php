<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProjectController;

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

Route::get('user', [UserController::class, 'index']);
Route::post('login', [AuthController::class, 'login']);
Route::post('admin/login', [AuthController::class, 'login']);
Route::prefix('member')->middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::prefix('admin')->middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::post('user/store', [UserController::class, 'store']);
    Route::post('user/delete', [UserController::class, 'destroy']);
    Route::get('user/show/{id}', [UserController::class, 'show']);
    Route::get('user', [UserController::class, 'index']);

    Route::post('category/store', [CategoryController::class, 'store']);
    Route::post('category/delete', [CategoryController::class, 'destroy']);
    Route::get('category/show/{id}', [CategoryController::class, 'show']);
    Route::get('category', [CategoryController::class, 'index']);

    Route::post('project/store', [ProjectController::class, 'store']);
    Route::post('project/delete', [ProjectController::class, 'delete']);
    Route::post('project/destroy', [ProjectController::class, 'destroy']);
    Route::post('project/restore', [ProjectController::class, 'restore']);
    Route::get('project/show/{id}', [ProjectController::class, 'show']);
    Route::get('project', [ProjectController::class, 'index']);
    Route::get('project/trash', [ProjectController::class, 'getTrash']);


});

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
