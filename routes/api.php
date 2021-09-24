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
    /**************************************************************************************************************/
    /********************************************** authentication ************************************************/
    /**************************************************************************************************************/

    // login route
    Route::post('login', 'ApiController@login');

    // social login route
    Route::post('social-login', 'ApiController@socialLogin');

    // register route
    Route::post('register', 'ApiController@register');

    // email verification route
    Route::post('verify', 'ApiController@verify');

    // reset password route
    Route::post('reset-password', 'ApiController@resetPassword');

    // change password route
    Route::post('change-password', 'ApiController@changePassword');

    // logout route
    Route::post('logout', 'ApiController@logout');

    // profile route
    Route::post('profile', 'ApiController@profile');

    // update profile route
    Route::post('update-profile', 'ApiController@updateProfile');

    /**************************************************************************************************************/
    /************************************************* all apis ***************************************************/
    /**************************************************************************************************************/

    //get all sections
    Route::post('sections', 'ApiController@sections');

    //get all categories where('section_id', $section_id)
    Route::post('categories', 'ApiController@categories');

    //get all sub categories where('category_id', $category_id)
    Route::post('sub-categories', 'ApiController@subCategories');

    //get fields where('sub_category_id', $subCategory_id)
    Route::post('fields', 'ApiController@fields');

    /**************************************************************************************************************/
    /************************************************* services ***************************************************/
    /**************************************************************************************************************/

    //get all services where('sub_category_id', $subCategory_id)
    Route::post('services', 'ApiController@services');

    //get all services for user where('user_id', $user_id)
    Route::post('services-for-user', 'ApiController@servicesForUser');

    //add new service
    Route::post('add-service', 'ApiController@addNewService');

    //edit service
    Route::post('edit-service', 'ApiController@editService');
});
