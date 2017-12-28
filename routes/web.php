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




Route::get('/','IndexController@index'); //call home page
Route::get('market', 'HomeController@index'); // call trade page
Route::get('market/{market}', 'HomeController@index');
Route::get('page/{page}', 'HomeController@routePage');
Route::post('get-chart', 'HomeController@getChart');
Route::post('voting', 'VoteCoinController@doVoting');
Route::get('maintenance', 'HomeController@maintenanceMode');
Route::get('/locale/{locale}', 'BaseController@setLocale' ); //link guide: http://laravel-vsjr.blogspot.com/2013/08/managing-laravel-4-localization-language.html
//pages , news
Route::get('post/{post}', 'HomeController@viewPost');




//Logged in users/admin cannot access or send requests these pages
Route::group(['middleware' => 'admin_guest'], function() {
 Route::get('admin_login', 'AdminAuth\LoginController@showLoginForm');
 Route::post('admin_login', 'AdminAuth\LoginController@login');
});

//Only logged in admin can access or send requests to these pages
Route::group(['middleware' => 'admin_auth'], function(){
 Route::post('admin_logout', 'AdminAuth\LoginController@logout');
 Route::get('/admin_home', function(){
   return view('admin.home');
 });
});



//trading
Route::post('dobuy', 'OrderController@doBuy');
Route::post('dosell', 'OrderController@doSell');
Route::post('docancel', 'OrderController@doCancel');
Route::post('dotest', 'HomeController@doTest');
Route::post('get-orderdepth-chart', 'OrderController@getOrderDepthChart');


// Confide routes
Route::get( 'referral/{referral}','UserController@create');
Route::get( 'user/register','UserController@create');
Route::post('user','UserController@store');
Route::get( 'login','UserController@login');
Route::post('user/login','Auth\LoginController@do_login');
Route::get( 'user/confirm/{code}','UserController@confirm');
Route::get( 'user/forgot_password','UserController@forgot_password');
Route::post('user/forgot_password','UserController@do_forgot_password');
Route::get( 'user/reset_password/{token}','UserController@reset_password');
Route::post('user/reset_password','UserController@do_reset_password');
Route::get( 'user/logout','UserController@logout');
//Route::post( 'check-captcha','UserController@checkCaptcha');
Route::get( 'check-captcha','UserController@checkCaptcha');
Route::post( 'user/update-setting','UserController@updateSetting');
Route::post( 'user/add-infoverify','UserController@addInfoVerify');


//user profile
Route::group(array('before' => 'auth','prefix' => 'user','middleware' => 'auth'), function () {
  Route::get('profile', 'UserController@viewProfile');
  Route::get('profile/{page}', 'UserController@viewProfile');
  Route::post('profile/{page}', 'UserController@viewProfile');
  Route::get('profile/{page}/{filter}', 'UserController@viewProfile');
  Route::post('profile/{page}/{filter}', 'UserController@viewProfile');
  Route::get('deposit/{wallet_id}', 'UserController@formDeposit');
  Route::get('withdraw/{wallet_id}', 'UserController@formWithdraw');
  Route::post('withdraw', 'UserController@doWithdraw');
  Route::get('withdraw-comfirm/{withdraw_id}/{confirmation_code}', 'UserController@comfirmWithdraw');
  Route::post('referrer-tradekey', 'UserController@referreredTradeKey');
  Route::post('cancel-withdraw', 'UserController@cancelWithdraw');
  //transfer
  Route::get('transfer-coin/{wallet_id}', 'UserController@formTransfer');
  Route::post('transfer-coin', 'UserController@doTransfer');
  /* Route::post('viewtranfer/{type}', 'UserController@viewTransferOut');*/
  Route::post('notify-deposit', 'UserController@addDepositCurrency');
  Route::post('notify-withdraw', 'UserController@addWithdrawCurrency');
});



//authy two-factor auth
Route::post( '/postrequestauth', 'AuthController@ajaxRequestInstallation' );
Route::post( '/first_auth', 'UserController@firstAuth' );
Route::post( 'user/verify_token', 'AuthController@ajVerifyToken' );
Route::post( '/postuninstalltwoauth', 'AuthController@ajaxUninstallation' );