<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/products', [ProductController::class, 'index']);

Route::prefix('/product')->group( function () {
    Route::get('/{id}', [ProductController::class, 'read']);
    Route::get('/{id}/images', [ProductController::class, 'getImages']);
    Route::post('/{id}/images', [ProductController::class, 'addImages']);
    Route::post('/store', [ProductController::class, 'store']);
    Route::put('/{id}', [ProductController::class, 'update']);
    Route::delete('/{id}', [ProductController::class, 'destroy']);
});

Route::post('/images', [ProductController::class, 'images']);
Route::delete('/images/{id}', [ProductController::class, 'deleteImages']);

Route::get('/categories', [ProductController::class, 'categories']);
Route::get('/category/{category}', [ProductController::class, 'category']);

Route::get('/search/{keyword}', [ProductController::class, 'search']);

Route::get('/user', [AuthController::class, 'getUser']);
