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


Route::group(['prefix' => LaravelLocalization::setLocale()], function () {

    Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
        // home route
        Route::get('/', 'HomeController@index')->name('home');
        // services routes
        Route::resource('services', 'ServiceController');
    });
});



