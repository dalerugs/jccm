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
Route::get('generateTemporaryPassword', 'UserController@generateTemporaryPassword')->name("generateTemporaryPassword");
Route::get('resetPassword/{id}', 'UserController@resetPassword')->name("resetPassword");
Route::post('changePasswordApi', 'UserController@changePasswordApi')->name("changePasswordApi");

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
Route::get('test', 'MemberController@test')->name("test");
Route::post('readMembersWithFilter', 'MemberController@readWithFilter')->name("readMembersWithFilter");
Route::get('showMember/{id}', 'MemberController@show')->name("showMember");
Route::post('updateMember', 'MemberController@update')->name("updateMember");
Route::get('toggleMemberStatus/{id}/{inactive}', 'MemberController@updateStatus')->name("toggleMemberStatus");
Route::get('deleteMember/{id}', 'MemberController@delete')->name("deleteMember");

Route::post('createRequest', 'MemberRequestController@create')->name("createRequest");
Route::get('readRequests', 'MemberRequestController@read')->name("readRequests");
Route::post('readRequestsWithFilter', 'MemberRequestController@readWithFilter')->name("readRequestsWithFilter");
Route::get('showRequest/{id}', 'MemberRequestController@show')->name("showRequest");
Route::get('approveRequest/{id}', 'MemberRequestController@approveRequest')->name("approveRequest");
Route::post('rejectRequest', 'MemberRequestController@rejectRequest')->name("rejectRequest");
Route::get('deleteRequest/{id}', 'MemberRequestController@delete')->name("deleteRequest");
Route::get('countRequests', 'MemberRequestController@count')->name("countRequests");


Route::post('readActivityLogs', 'ActivityLogController@read')->name("readActivityLogs");
Route::get('countLogs/{id}', 'ActivityLogController@count')->name("countLogs");

Route::get('pepsolReport/{id}', 'PepsolReportController@calculateNetworkPepsolReport')->name("pepsolReport");
