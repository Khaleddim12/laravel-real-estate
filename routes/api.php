<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\auth\AdminRegisterController;
use App\Http\Controllers\auth\AuthenticatedSessionController;
use App\Http\Controllers\auth\CustomerRegisterController;
use App\Http\Controllers\auth\VendorRegisterController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DealController;
use App\Http\Controllers\EstateController;
use App\Http\Controllers\VendorController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/register/vendor', [VendorRegisterController::class, 'store'])->middleware('guest');
Route::post('/register/customer', [CustomerRegisterController::class, 'store'])->middleware('guest');
Route::post('/register/admin', [AdminRegisterController::class, 'store'])->middleware('guest');
Route::post('/login', [AuthenticatedSessionController::class, 'login'])->middleware('guest')->name('login');




Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->middleware('auth')->name('logout');

    Route::get('customer/{customer}', [CustomerController::class, 'show']);
    Route::post('customer/{customer}',[CustomerController::class, 'update']);
    Route::delete('customer/{customer}',[CustomerController::class, 'destroy']);
    //Route::put('customer/{customer}',[CustomerController::class, 'update'])->middleware("can:update,customer");

    Route::apiResource('vendor',VendorController::class);

    Route::apiResource('admin',AdminController::class);

    Route::apiResource('estate', EstateController::class);


    Route::post('/deal/{estate}', [DealController::class, 'store']);
    Route::get('/deal/{deal}', [DealController::class, 'show']);
    Route::put('/deal/{deal}/done', [DealController::class, 'done']);
    Route::delete('/deal/{deal}', [DealController::class, 'destroy']);

});
