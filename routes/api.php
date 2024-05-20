<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\EmailController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// dashboard route
Route::get('/dashboard', [DashboardController::class,'index']);
// pages routes
Route::resource('users', UserController::class);
Route::resource('vehicles', VehicleController::class);
Route::post('/option/value', [UserController::class,'option']);
// correo
Route::post('/send-email', [EmailController::class, 'sendEmail']);