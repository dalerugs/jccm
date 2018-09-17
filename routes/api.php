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

Route::post('createFile', 'FileController@create')->name("createFile");
Route::get('readFiles', 'FileController@read')->name("readFiles");
Route::get('showFile/{id}', 'FileController@show')->name("showFile");
Route::post('updateFile', 'FileController@update')->name("updateFile");
Route::get('deleteFile/{id}', 'FileController@delete')->name("deleteFile");

Route::post('createMember', 'MemberController@create')->name("createMember");
Route::get('readMembers', 'MemberController@read')->name("readMembers");
Route::post('readMembersWithFilter', 'MemberController@readWithFilter')->name("readMembersWithFilter");
Route::get('showMember/{id}', 'MemberController@show')->name("showMember");
Route::post('updateMember', 'MemberController@update')->name("updateMember");
Route::get('toggleMemberStatus/{id}/{inactive}', 'MemberController@updateStatus')->name("toggleMemberStatus");
Route::get('deleteMember/{id}', 'MemberController@delete')->name("deleteMember");
