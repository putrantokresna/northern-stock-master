<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['guest_mid'])->group(function () {
    Route::get('login', 'App\Http\Controllers\AuthController@index')->name('login');
    Route::post('login', 'App\Http\Controllers\AuthController@store')->name('login.post');
});

Route::middleware(['user_mid'])->group(function () {
    Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');
    Route::get('/notification', 'App\Http\Controllers\HomeController@getNotification')->name('home.notification');
    Route::post('home/masuk', 'App\Http\Controllers\HomeController@masuk')->name('home.masuk');
    Route::post('home/masuk/update', 'App\Http\Controllers\HomeController@updateMasuk')->name('home.masuk.update');
    Route::post('home/keluar', 'App\Http\Controllers\HomeController@keluar')->name('home.keluar');

    Route::get('product/home', 'App\Http\Controllers\ProductController@index')->name('product');
    Route::get('product/export', 'App\Http\Controllers\ProductController@export')->name('product.export');

    Route::get('history/home', 'App\Http\Controllers\HistoryController@index')->name('history');

    Route::get('message/home', 'App\Http\Controllers\MessageController@index')->name('message');
    Route::get('message/delete/{id}', 'App\Http\Controllers\MessageController@delete')->name('message.delete');

    Route::get('opname/home', 'App\Http\Controllers\OpnameController@index')->name('opname');
    Route::post('opname/edit', 'App\Http\Controllers\OpnameController@store')->name('opname.post');
    Route::get('opname/export', 'App\Http\Controllers\OpnameController@export')->name('opname.export');

    Route::get('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');
});

Route::middleware(['admin_mid'])->group(function () {
    Route::get('product/delete/{id}', 'App\Http\Controllers\ProductController@delete')->name('product.delete');
    Route::get('product/edit/{id?}', 'App\Http\Controllers\ProductController@edit')->name('product.edit');
    Route::post('product/edit', 'App\Http\Controllers\ProductController@store')->name('product.post');

    Route::get('history/delete/{id}', 'App\Http\Controllers\HistoryController@delete')->name('history.delete');

    Route::get('employee/home', 'App\Http\Controllers\EmployeeController@index')->name('employee');
    Route::get('employee/delete/{id}', 'App\Http\Controllers\EmployeeController@delete')->name('employee.delete');
    Route::get('employee/edit/{id?}', 'App\Http\Controllers\EmployeeController@edit')->name('employee.edit');
    Route::post('employee/edit', 'App\Http\Controllers\EmployeeController@store')->name('employee.post');
});