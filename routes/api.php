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

// Verify email
Route::get('/email/verify/{id}/{hash}', 'VerifyEmailController@__invoke')
    ->name('verification.verify');

// Resend link to verify email
Route::post('/email/verify/resend', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
});

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');

Route::group(['middleware' => 'auth:api'], function(){

    Route::get('/destinasis', 'App\Http\Controllers\DestinasiController@index');
    Route::get('/destinasis/{id}', 'App\Http\Controllers\DestinasiController@show');
    Route::post('/destinasis', 'App\Http\Controllers\DestinasiController@store');
    Route::put('/destinasis/{id}', 'App\Http\Controllers\DestinasiController@update');
    Route::delete('/destinasis/{id}', 'App\Http\Controllers\DestinasiController@destroy');

    Route::get('/ratings', 'App\Http\Controllers\RatingController@index');
    Route::get('/ratings/{id}', 'App\Http\Controllers\RatingController@show');
    Route::post('/ratings', 'App\Http\Controllers\RatingController@store');
    Route::put('/ratings/{id}', 'App\Http\Controllers\RatingController@update');
    Route::delete('/ratings/{id}', 'App\Http\Controllers\RatingController@destroy');

    Route::get('/planners', 'App\Http\Controllers\PlannerController@index');
    Route::get('/planners/{id}', 'App\Http\Controllers\PlannerController@show');
    Route::get('/plannersAll/{id_user}', 'App\Http\Controllers\PlannerController@indexById');
    Route::post('/planners', 'App\Http\Controllers\PlannerController@store');
    Route::put('/planners/{id}', 'App\Http\Controllers\PlannerController@update');
    Route::delete('/planners/{id}', 'App\Http\Controllers\PlannerController@destroy');

    Route::get('/users', 'App\Http\Controllers\UserController@index');
    Route::get('/users/{id}', 'App\Http\Controllers\UserController@show');
    Route::post('/users/{id}', 'App\Http\Controllers\UserController@update');

  Route::post('logout', 'Api\AuthController@logoutApi');
});