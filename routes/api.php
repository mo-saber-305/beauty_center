<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->namespace('Api')->group(function () {

    // login route
    Route::post('login', 'ApiController@login');

    // register route
    Route::post('register', 'ApiController@register');

    // email verification route
    Route::post('verify', 'ApiController@verify');

    // logout route
    Route::post('logout', 'ApiController@logout');

    // profile route
    Route::post('profile', 'ApiController@profile');

    //get all sections
    Route::post('sections', 'ApiController@sections');

    //get all categories where('section_id', $section_id)
    Route::post('categories', 'ApiController@categories');

    //get all sub categories where('category_id', $category_id)
    Route::post('sub-categories', 'ApiController@subCategories');

    //get fields where('sub_category_id', $subCategory_id)
    Route::post('fields', 'ApiController@fields');

    /**************************************************************************************************************/
    // services //
    /**************************************************************************************************************/
    //get all services where('sub_category_id', $subCategory_id)
    Route::post('services', 'ApiController@services');
    //add new service
    Route::post('add-service', 'ApiController@addNewService');
});
