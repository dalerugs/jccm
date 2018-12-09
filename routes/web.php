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

Route::get('sharehub', 'ShareHubController@showShareHubLanding')->name("sharehub");

Route::get('', 'AuthController@showLogin')->name("login")->middleware('guest');
Route::post('login', 'AuthController@doLogin')->name("doLogin");
Route::get('logout', 'AuthController@doLogout')->name("logout");

Route::get('dashboard', 'DashboardController@index')->name("dashboard");


Route::get('admin', 'AdminController@index')->name("admin")->middleware('auth');
Route::get('admin/manageUsers', 'AdminController@manageUsers')->name("manageUsers")->middleware('auth');
Route::get('admin/manageMembers', 'AdminController@manageMembers')->name("manageMembers")->middleware('auth');
Route::get('admin/manageBatch', 'AdminController@manageBatch')->name("manageBatch")->middleware('auth');
Route::get('admin/manageFiles', 'AdminController@manageFiles')->name("manageFiles")->middleware('auth');
Route::get('admin/manageRequests', 'AdminController@manageRequests')->name("manageRequests")->middleware('auth');

Route::get('files', 'FileController@showFilesPage')->name("files")->middleware('auth');
Route::get('members', 'MemberController@showMembersPage')->name("members")->middleware('auth');
Route::get('pepsol', 'PepsolReportController@index')->name("pepsol")->middleware('auth');

Route::get('myNetwork', 'MyNetworkController@showMyNetworkMenu')->name("myNetwork")->middleware('auth');
Route::get('myNetwork/manageMembers', 'MyNetworkController@manageMembers')->name("myNetworkMembers")->middleware('auth');
Route::get('myNetwork/manageRequests', 'MyNetworkController@manageRequests')->name("myNetworkRequests")->middleware('auth');
