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

Route::get('/', 'HomeController@index')->middleware('auth');


Route::group(['prefix' => 'dentist', 'middleware' => 'auth'], function(){
    Route::post('/{dentistId}/appointment', 'DentistController@createAppointment');
    Route::post('/{dentistId}/review', 'DentistController@createReview');
    Route::post('/search', 'DentistController@search');
    Route::get('/{dentistId}', 'DentistController@getDentistProfile');
});

Route::get('/appointment/{id}/cancel', 'AppointmentController@cancel');

Auth::routes();

Route::group(['prefix' => 'int', 'middleware' => 'auth'], function()
{
    Route::get('/schedule/{dentistId}', 'InternalController@getSchedulesByDentistId');
    Route::get('/appointment/{dentistId}/{date}', 'InternalController@getScheduledAppointmentsByDentistId');
});

//Mail routes
Route::get('sendbasicemail','MailController@basic_email');
Route::get('sendhtmlemail','MailController@html_email');
Route::get('sendattachmentemail','MailController@attachment_email');
