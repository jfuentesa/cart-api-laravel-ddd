<?php

use App\CartAPI\CartController;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

/**
 * Rutas de la API de carrito, del grupo /api...
 */
Route::prefix('v1/cart')->group(function () {
    Route::get('{id}/list', [CartController::class, 'list']);
    Route::post('{id}/additem/{productId}', [CartController::class, 'addItem']);
    Route::delete('{id}/deleteitem/{productId}', [CartController::class, 'deleteItem']);
    Route::delete('{id}/deleteitemall/{productId}', [CartController::class, 'deleteItemAll']);
    Route::delete('{id}/clear', [CartController::class, 'clear']);
    Route::post('{id}/pay', [CartController::class, 'pay']);
});
