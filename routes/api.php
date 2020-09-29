<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('login', 'AuthController');
Route::resource('alerts', 'AlertController');

Route::post('alerts/actualizar/imagen', 'AlertController@actualizarAlerta');


Route::group(['prefix' => 'places'], function () {
    Route::get('/', 'PlacesController@index');
    Route::post('/', 'PlacesController@store');
    Route::get("/{id}", 'PlacesController@show');
    Route::post("/{id}", 'PlacesController@update');
    Route::delete('/{id}', 'PlacesController@destroy');
});


Route::group(['prefix' => 'publicInstitutions'], function () {
    Route::get('/', 'InstitutionsController@index');
    Route::post('/', 'InstitutionsController@store');
    Route::get("/{id}", 'InstitutionsController@show');
    Route::post("/{id}", 'InstitutionsController@update');
    Route::delete('/{id}', 'InstitutionsController@destroy');
});



Route::group(['prefix' => 'unattendedAlert'], function () {
    Route::get('/', 'AlertController@unattendedAlert');
    Route::get('/2', 'AlertController@unattendedAlerts_U2');
    Route::get('/3', 'AlertController@unattendedAlerts_U3');
    Route::get('/4', 'AlertController@unattendedAlerts_U4');
});

Route::get('placesType/{type}', 'PlacesController@placesType');
Route::get('graph', 'stadisticsController@getMonthlyAlertData');

Route::get('alertImg/{filename}', 'AlertController@image');

Route::get('alertsUser/{cod}', 'AlertController@alertsUser');

Route::group(['prefix' => 'home'], function () {
    Route::get('/', 'BlogController@getHome');
    Route::post('/', 'BlogController@storeHome');
    Route::get("/{id}", 'BlogController@showHome');
    Route::post("/{id}", 'BlogController@updateHome');
    Route::delete("/{id}", 'BlogController@destroyHome');
});

Route::group(['prefix' => 'news'], function () {
    Route::get('/', 'BlogController@getNews');
    Route::post('/', 'BlogController@storeNews');
    Route::get("/{id}", 'BlogController@showNews');
    Route::post("/{id}", 'BlogController@updateNews');
    Route::delete("/{id}", 'BlogController@destroyNews');
});

Route::group(['prefix' => 'events'], function () {
    Route::get('/', 'BlogController@getEvents');
    Route::get('/eventsPast', 'BlogController@eventsPast');
    Route::get('/eventsAll', 'BlogController@eventsAll');
    Route::post('/', 'BlogController@storeEvents');
    Route::get("/{id}", 'BlogController@showEvents');
    Route::post("/{id}", 'BlogController@updateEvents');
    Route::delete("/{id}", 'BlogController@destroyEvents');
});

Route::group(['prefix' => 'associate'], function () {
    Route::get('/', 'BlogController@getAssociate');
    Route::post('/', 'BlogController@storeAssociate');
    Route::get("/{id}", 'BlogController@showAssociate');
    Route::post("/{id}", 'BlogController@updateAssociate');
    Route::delete('/{id}', 'BlogController@destroyAssociate');
});

Route::group(['prefix' => 'evacuationPoints'], function () {
    Route::get('/', 'PointsController@index');
    Route::post('/', 'PointsController@store');
    Route::get("/{id}", 'PointsController@show');
    Route::post("/{id}", 'PointsController@update');
    Route::delete('/{id}', 'PointsController@destroy');
});

Route::get('blogImg/{filename}', 'BlogController@image');

Route::get('resultado/{lat}/{long}','PolygonController@obtenerresultados');
//CREACION DEL PDF --
Route::get('/excel/{fecha_incio}/{fecha_fin}', 'AlertController@CreateExcel');
Route::get('/descargar/excel/{opcion}/{nombreExcel}', 'AlertController@DownloadExcel');


Route::get('/test-websocket', 'AlertController@testComunication');


Route::get('gender' , 'PersonsController@gender');
Route::get('userType/{id}', 'PersonsController@userType');

//BROTHER, TE OLVIDASTE COLOCAR ESTO
Route::resource('persons', 'PersonsController');
