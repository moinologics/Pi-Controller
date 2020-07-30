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


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/','Api\PiController@test');

Route::group(['prefix'=>'','namespace'=>'Api'],function(){

	Route::get('getpins','PiController@pinlist')->name('api.pi4.getpins');

	Route::group(['prefix'=>'board'],function(){

		Route::get('get/mode','PiController@BoardMode')->name('api.pi4.getboardmode');

		Route::post('set/mode/{value}','PiController@BoardMode')->name('api.pi4.setboardmode');
	});

	Route::group(['prefix'=>'pin'],function(){

		Route::get('{pin}/get/mode','PiController@PinMode')->name('api.pi4.getpinmode');

		Route::post('{pin}/set/mode/{value}','PiController@PinMode')->name('api.pi4.setpinmode');

		Route::get('{pin}/get/output','PiController@PinState')->name('api.pi4.getpinoutput');

		Route::post('{pin}/set/output/{value}','PiController@PinState')->name('api.pi4.setpinoutput');

	});

});
