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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('createUser', 'UserController@create')->name("createUser");
Route::get('readUsers', 'UserController@read')->name("readUsers");
Route::get('showUser/{id}', 'UserController@show')->name("showUser");
Route::post('updateUser', 'UserController@update')->name("updateUser");
Route::get('deleteUser/{id}', 'UserController@delete')->name("deleteUser");
