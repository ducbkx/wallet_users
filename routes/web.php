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
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

Route::get('information', 'UserController@information')->name('information');
Route::get('information/{id}/edit', 'UserController@edit');
Route::post('information/{id}/update', 'UserController@update')->name('information.update');

Route::get('change_password', 'UserController@showForm')->name('users.change_password');
Route::post('change_password', 'UserController@postChange')->name('users.password.postChange');

Route::get('createwallet', 'WalletController@showCreateWallet');
Route::post('createwallet', 'WalletController@creatWallet')->name('wallet.create');

Route::get('wallet', 'WalletController@listWallet')->name('wallet.list');

Route::get('wallet/{id}/edit', 'WalletController@edit')->name('wallet.edit');
Route::post('wallet/{id}/update', 'WalletController@update')->name('wallet.update');
Route::get('wallet/{id}/delete', 'WalletController@destroy')->name('wallet.destroy');

Route::get('wallet_exchange', 'WalletController@WalletExchange')->name('wallet.exchange');
Route::post('wallet_exchange', 'WalletController@WalletActionExchange')->name('wallet.action_exchange');
