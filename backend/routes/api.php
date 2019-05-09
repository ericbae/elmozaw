<?php

use Illuminate\Http\Request;

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

// Ideally, we will need to add our Auth middleware here. so that these endpoints are only accessible after going through
// our authentcation middleware - Zaw

// endpoint to get the list of all the forms that user has added
Route::get('forms', 'FormsController@list');
// end point to get the details of 1 specific  form
Route::get('forms/{formId}', 'FormsController@view');
// end point to delete specific from
Route::delete('forms/{formId}', 'FormsController@delete');
// end point to submit/edit the value of elements for specific form
Route::post('forms/{formId}', 'FormsController@edit');
// end point to upload file for specific element
Route::post('upload/{formElementId}', 'FormsController@fileUpload');
// end point to initiate new form without the associated elements yet
Route::post('build-forms/build', 'FormsBuilderController@create');
// end point to append associated elements to the form that is already been created
Route::post('build-forms/build/{formId}', 'FormsBuilderController@create');

