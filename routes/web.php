<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function (){
    return view('welcome');
});

Route::get('/routes', function (){

	$routeCollection = Route::getRoutes();
	
	foreach ($routeCollection as $value)
	{
		var_dump($value);
	}
});

Route::get('/test', 'Api\PiController@test');

Route::get('/test-esp', 'Api\EspController@test');


Route::get('/tank-meter', 'Api\PiController@tank_meter');

Route::get('/python-processes', 'Api\PiController@python_processes');


	