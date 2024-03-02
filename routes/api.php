<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\IbpTravelExpensesController;
use App\Http\Controllers\PowerSupplyController;
use App\Http\Controllers\TravelExpensesController;
use App\Http\Controllers\UserController;
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


Route::group(['middleware' => 'api', 'prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function () {

        Route::post('login', [AuthController::class, 'login']);
        Route::get('logout', [AuthController::class, 'logout']);
        Route::get('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);

    });

    Route::post('user', [UserController::class, 'create']);
    Route::get('user', [UserController::class, 'all']);
    Route::get('user/{id}', [UserController::class, 'get']);
    Route::put('user/{id}', [UserController::class, 'update']);
    Route::put('user/{id}/password', [UserController::class, 'changePassword']);
    Route::put('user/{id}/role', [UserController::class, 'changeRole']);

    Route::get('ibp', [PowerSupplyController::class, 'all']);
    Route::post('ibp', [PowerSupplyController::class, 'create']);
    Route::put('ibp/{id}', [PowerSupplyController::class, 'update']);
    Route::delete('ibp/{id}', [PowerSupplyController::class, 'delete']);
    Route::get('ibp/{id}', [PowerSupplyController::class, 'get']);

    Route::get('travel-expenses', [TravelExpensesController::class, 'all']);
    Route::post('travel-expenses', [TravelExpensesController::class, 'create']);
    Route::put('travel-expenses/{id}', [TravelExpensesController::class, 'update']);
    Route::delete('travel-expenses/{id}', [TravelExpensesController::class, 'delete']);
    Route::get('travel-expenses/{id}', [TravelExpensesController::class, 'get']);

    Route::post('calculate', [IbpTravelExpensesController::class, 'create']);
    Route::get('calculate', [IbpTravelExpensesController::class, 'all']);
    Route::get('calculate/{id}', [IbpTravelExpensesController::class, 'get']);
    Route::put('calculate/{id}', [IbpTravelExpensesController::class, 'change']);
    Route::delete('calculate/{id}', [IbpTravelExpensesController::class, 'delete']);
});
