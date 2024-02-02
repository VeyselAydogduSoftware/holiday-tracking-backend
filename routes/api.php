<?php

use Illuminate\Http\Request;
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

Route::get('/', function () {

    return response()->json('Hello World');

});

Route::group(['name' => 'Api', 'middleware' => ['FakeLogin']], function () {

    Route::get('/user', function () {

        return response()->json(auth()->user());

    });

    Route::group(['name' => 'holidays'], function (){

        Route::apiResource('holidays', \App\Http\Controllers\API\HolidayController::class);

    });

});
