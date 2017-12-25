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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//Logged in users/seller cannot access or send requests these pages
Route::group(['middleware' => 'admin_guest'], function() {
 
 Route::get('admin_login', 'AdminAuth\LoginController@showLoginForm');
 Route::post('admin_login', 'AdminAuth\LoginController@login');

});


//Only logged in sellers can access or send requests to these pages
Route::group(['middleware' => 'admin_auth'], function(){

 Route::post('admin_logout', 'AdminAuth\LoginController@logout');
 Route::get('/admin_home', function(){
   return view('admin.home');
 });

});