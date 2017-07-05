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

    Route::resource('cliente', 'ClientController', ['except'=>['create','edit']]);
    Route::resource('projeto', 'ProjectController', ['except'=>['create','edit']]);

    //Route::get('projeto.membro', 'ProjectController@projectsMember');
    Route::resource('projeto.membro', 'ProjectMemberController', ['except'=>['create','edit','update']]);

    Route::group(['middleware' => 'check.project.permission','prefix'=>'projeto'], function (){

        Route::get('{id}/nota', 'ProjectNoteController@index');
        Route::post('{id}/nota', 'ProjectNoteController@store');
        Route::get('{id}/nota/{noteId}', 'ProjectNoteController@show');
        Route::put('{id}/nota/{noteId}', 'ProjectNoteController@update');
        Route::delete('{id}/nota/{noteId}', 'ProjectNoteController@destroy');

        Route::get('{id}/arquivo', 'ProjectFileController@index');
        Route::post('{id}/arquivo', 'ProjectFileController@store');
        Route::get('{id}/arquivo/{fileId}', 'ProjectFileController@show');
        Route::get('{id}/arquivo/{fileId}/download', 'ProjectFileController@showFile');
        Route::put('{id}/arquivo/{fileId}', 'ProjectFileController@update');
        Route::delete('{id}/arquivo/{fileId}', 'ProjectFileController@destroy');

        Route::get('{id}/tarefa','ProjectTaskController@index');
        Route::post('{id}/tarefa','ProjectTaskController@store');
        Route::get('{id}/tarefa/{taskId}','ProjectTaskController@show');
        Route::put('{id}/tarefa/{taskId}', 'ProjectTaskController@update');
        Route::delete('{id}/tarefa/{taskId}', 'ProjectTaskController@destroy');

    });

    Route::get('user/authenticated', 'UserController@authenticated');
    Route::resource('user','UserController',['except' => ['create','edit']]);

});

