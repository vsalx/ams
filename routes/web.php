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
})->middleware('auth');


Route::group(['prefix' => 'dentist', 'middleware' => 'auth'], function(){
    Route::get('/{dentistId}/appointment', 'DentistAppointmentController@getAppointmentView');
    Route::post('/{dentistId}/appointment', 'DentistAppointmentController@createAppointment');
});


Auth::routes();

Route::group(['prefix' => 'int', 'middleware' => 'auth'], function()
{
    Route::get('/schedule/{dentistId}', 'InternalController@getSchedulesByDentistId');
    Route::get('/appointment/{dentistId}/{date}', 'InternalController@getScheduledAppointmentsByDentistId');
});
