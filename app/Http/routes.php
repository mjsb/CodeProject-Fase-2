<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});


/*Route::get('projeto', function() {

	echo "Olá!";
	return \CodeProject\Project::all();

});*/

Route::get('cliente', 'ClientController@index');
Route::post('cliente', 'ClientController@store');
Route::get('cliente/{id}', 'ClientController@show');
Route::delete('cliente/{id}', 'ClientController@destroy');
Route::post('cliente/edit/{id}', 'ClientController@update');

Route::get('projeto', 'ProjectController@index');
Route::post('projeto', 'ProjectController@store');
Route::get('projeto/{id}', 'ProjectController@show');
Route::delete('projeto/{id}', 'ProjectController@destroy');
Route::post('projeto/edit/{id}', 'ProjectController@update');