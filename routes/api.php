<?php

use App\Http\Controllers\Api\V1\Manage\AuthController;
use App\Http\Controllers\Api\V1\Manage\Product\ProductController;
use App\Http\Controllers\Api\V1\Manage\ProductItem\ProductItemController;
use App\Http\Controllers\Api\V1\Manage\Role\RoleController;
use App\Http\Controllers\Api\V1\Manage\User\UserController;
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
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResource('products', ProductController::class);
    Route::apiResource('product-items', ProductItemController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('roles', RoleController::class);
    Route::get('test', function () {
        return (new \App\Repositories\UserRepository())->userAccessMethodsList();
    });
});


