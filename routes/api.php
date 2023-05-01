<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Authorized\{
    FavoriteController, ProductController
};
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/products', [\App\Http\Controllers\Api\ProductController::class, 'index'])->name('products.index');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/registration', [AuthController::class, 'registration'])->name('registration');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware('auth:sanctum')->prefix('auth')
    ->name('auth.')->group(function () {
        Route::post('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout'])->name('logout');
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
        Route::post('/favorites/{product}', [FavoriteController::class, 'store'])
            ->name('favorites.store');
        Route::delete('/favorites/{favorite}', [FavoriteController::class, 'delete'])
            ->name('favorites.delete');

        Route::apiResource('products',ProductController::class)->except(['show','edit','update']);
        Route::post('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');
    });
