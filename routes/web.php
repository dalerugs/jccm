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

// Route::get('/info', function () {
//     phpinfo();
// });

Route::get('', 'AuthController@showLogin')->name("login")->middleware('guest');
Route::post('login', 'AuthController@doLogin')->name("doLogin");
Route::get('logout', 'AuthController@doLogout')->name("logout");

Route::get('dashboard', 'DashboardController@index')->name("dashboard");


Route::get('admin', 'AdminController@index')->name("admin");
Route::get('admin/manageUsers', 'AdminController@manageUsers')->name("manageUsers");
Route::get('admin/manageMembers', 'AdminController@manageMembers')->name("manageMembers");
Route::get('admin/manageBatch', 'AdminController@manageBatch')->name("manageBatch");
Route::get('admin/manageFiles', 'AdminController@manageFiles')->name("manageFiles");
Route::get('admin/manageRequests', 'AdminController@manageRequests')->name("manageRequests");

Route::get('files', 'FileController@showFilesPage')->name("files");
Route::get('members', 'MemberController@showMembersPage')->name("members");
Route::get('pepsol', 'PepsolReportController@index')->name("pepsol");

Route::get('myNetwork', 'MyNetworkController@showMyNetworkMenu')->name("myNetwork");
Route::get('myNetwork/manageMembers', 'MyNetworkController@manageMembers')->name("myNetworkMembers");
Route::get('myNetwork/manageRequests', 'MyNetworkController@manageRequests')->name("myNetworkRequests");
