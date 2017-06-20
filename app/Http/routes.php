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
    return view('app');
});

/*Route::get('projeto', function() {

	echo "Olá!";
	return \CodeProject\Project::all();

});*/

Route::post('oauth/access_token', function() {

    $input = \Input::all();
    $request = \Request::instance();
    $request->request->replace($input);
    Authorizer::setRequest($request);

    return Response::json(Authorizer::issueAccessToken());
});

Route::group(['middleware'=>'oauth'], function () {

    Route::resource('cliente', 'ClientController', ['except'=>['create', 'edit']]);

    /*Route::group(['middleware' => 'CheckProjectOwner'], function () {
        Route::resource('projeto', 'ProjectController', ['except'=>['create', 'edit']]);
    });*/

    Route::resource('projeto', 'ProjectController', ['except'=>['create', 'edit']]);


    Route::group(['prefix'=>'projeto'], function (){

        Route::get('{id}/nota', 'ProjectNoteController@index');
        Route::post('{id}/nota', 'ProjectNoteController@store');
        Route::get('{id}/nota/{noteId}', 'ProjectNoteController@show');
        Route::put('{id}/nota/{noteId}', 'ProjectNoteController@update');
        Route::delete('{id}/nota/{noteId}', 'ProjectNoteController@destroy');

        Route::get('{id}/membro','ProjectController@showMembers');
        Route::get('{id}/membro/{membroId}','ProjectController@member');
        Route::put('{id}/membro/{membroId}', 'ProjectController@addmember');
        Route::delete('{id}/membro/{membroId}', 'ProjectController@removemember');

        Route::get('{id}/task','ProjectTaskController@index');
        Route::get('{id}/task/{taskId}','ProjectTaskController@show');

        Route::post('{id}/file','ProjectFileController@store');

    });

    Route::get('user/authenticated', 'UserController@authenticated');

    /*

    Route::get('cliente', ['middleware'=>'oauth', 'uses'=>'ClientController@index']);
    Route::post('cliente', 'ClientController@store');
    Route::get('cliente/{id}', 'ClientController@show');
    Route::delete('cliente/{id}', 'ClientController@destroy');
    Route::post('cliente/edit/{id}', 'ClientController@update');

    Route::get('projeto/{id}/note', 'ProjectNoteController@index');
    Route::post('projeto/{id}/note', 'ProjectNoteController@store');
    Route::get('projeto/{id}/note/{noteId}', 'ProjectNoteController@show');
    Route::put('projeto/{id}/note/{noteId}', 'ProjectNoteController@update');
    Route::delete('projeto/{id}/note/{noteId}', 'ProjectNoteController@delete');

    Route::get('projeto', 'ProjectController@index');
    Route::post('projeto', 'ProjectController@store');
    Route::get('projeto/{id}', 'ProjectController@show');
    Route::delete('projeto/{id}', 'ProjectController@destroy');
    Route::post('projeto/edit/{id}', 'ProjectController@update');

    */

});

