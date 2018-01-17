<?php

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

Route::get('/', function () {
    return view('home');
});


Route::get('/appointment', function () {
    return view('appointment');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'int'], function()
{
    Route::get('/schedule/{dentistId}', 'InternalController@getSchedulesByDentistId');
    Route::get('/appointment/{dentistId}/{date}', 'InternalController@getScheduledAppointmentsByDentistId');
});
