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

Route::middleware('auth:api')->get('/user', function (Request $request)
{
    return $request->user();
});

//**************** Authentication ****************

Route::post('/register', 'AuthController@register');
Route::post('/login', 'AuthController@login');


//**************** Users ****************

Route::get('/get_users', 'UsersController@get_users');


//**************** Files ****************

Route::get('/get_all_files', 'FilesController@get_all_files');
Route::post('/upload_image', 'FilesController@upload_image');
Route::post('/upload_video', 'FilesController@upload_video');

//**************** Surprises ****************

Route::post('/create_surprise', 'SurprisesController@create_surprise');
Route::get('/get_surprise_by_id', 'SurprisesController@get_surprise_by_id');
Route::get('/get_my_sended', 'SurprisesController@get_my_sended');
Route::get('/get_my_received', 'SurprisesController@get_my_received');
Route::post('/reject_surprise', 'SurprisesController@reject_surprise');
Route::post('/update_reaction', 'SurprisesController@update_reaction');



