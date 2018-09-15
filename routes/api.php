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

Route::post('createBatch', 'BatchController@create')->name("createBatch");
Route::get('readBatch', 'BatchController@read')->name("readBatch");
Route::get('showBatch/{id}', 'BatchController@show')->name("showBatch");
Route::post('updateBatch', 'BatchController@update')->name("updateBatch");
Route::get('deleteBatch/{id}', 'BatchController@delete')->name("deleteBatch");

Route::post('createMember', 'MemberController@create')->name("createMember");
Route::get('readMembers', 'MemberController@read')->name("readMembers");
Route::get('showMember/{id}', 'MemberController@show')->name("showMember");
Route::post('updateMember', 'MemberController@update')->name("updateMember");
Route::get('deleteMember/{id}', 'MemberController@delete')->name("deleteMember");
