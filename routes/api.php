<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function(){
  Route::apiResource('/destinasis', App\Http\Controllers\DestinasiController::class);
  Route::apiResource('/ratings', App\Http\Controllers\RatingController::class);
  Route::apiResource('/planners', App\Http\Controllers\PlannerController::class);
  Route::post('logout', 'Api\AuthController@logoutApi');
});