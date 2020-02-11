<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\AuthController;

use App\Http\Controllers\Api\DomainController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\JsonController;

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

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::get('refresh', [AuthController::class, 'refresh']);
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('user', [AuthController::class, 'user']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::group(['middleware' => 'auth:api'], function () {
    // Users
    Route::get('users', 'UserController@index')->middleware('isAdmin');
    Route::get('users/{id}', 'UserController@show')->middleware('isAdminOrSelf');

    Route::get('domain/{id}', [DomainController::class, 'getDomain']);
    Route::get('domains', [DomainController::class, 'listDomains']);
    Route::post('newDomain', [DomainController::class, 'createDomain']);
    Route::delete('deleteDomain/{id}', [DomainController::class, 'deleteDomain']);

    Route::post('addCategory', [CategoryController::class, 'addCategory']);
    Route::delete('deleteCategory/{id}', [CategoryController::class, 'deleteCategory']);

    Route::post('createProduct', [ProductController::class, 'createProduct']);
    Route::get('loadTree/{id}', [ProductController::class, 'loadTree']);

});

Route::get('downloadJson/{id}', [JsonController::class, 'download']);
