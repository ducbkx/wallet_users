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

Route::get('create_wallet', 'WalletController@showCreateWallet')->name('wallet.add');
Route::post('create_wallet', 'WalletController@creatWallet')->name('wallet.create');

Route::get('wallet', 'WalletController@listWallet')->name('wallet.list');

Route::get('wallet/{id}/edit', 'WalletController@edit')->name('wallet.edit');
Route::post('wallet/{id}/update', 'WalletController@update')->name('wallet.update');
Route::get('wallet/{id}/delete', 'WalletController@destroy')->name('wallet.destroy');

Route::get('wallet_exchange', 'WalletController@WalletExchange')->name('wallet.exchange');
Route::post('wallet_exchange', 'WalletController@WalletActionExchange')->name('wallet.action_exchange');

Route::get('create_transaction','TransactionController@showCreatTransaction')->name('add_transaction');
Route::post('create_transaction','TransactionController@creatTransaction')->name('create_transaction');

Route::get('transaction', 'TransactionController@listTransaction')->name('transaction.list');

Route::get('transaction/{id}/edit', 'TransactionController@edit')->name('transaction.edit');
Route::post('transaction/{id}/update', 'TransactionController@update')->name('transaction.update');
Route::get('transaction/{id}/delete', 'TransactionController@destroy')->name('transaction.destroy');

Route::get('create_exchange','ExchangeController@showCreatExchange')->name('exchange');
Route::post('create_exchange','ExchangeController@creatExchange')->name('create_exchange');

Route::get('exchange', 'ExchangeController@listExchange')->name('exchange.list');

Route::get('exchange/{id}/edit', 'ExchangeController@edit')->name('exchange.edit');
Route::post('exchange/{id}/update', 'ExchangeController@update')->name('exchange.update');
Route::get('exchange/{id}/delete', 'ExchangeController@destroy')->name('exchange.destroy');

Route :: get ('report', 'ExchangeController@report')->name('exchange.report');