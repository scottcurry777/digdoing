<?php

use Illuminate\Http\Request;

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

// Login
/*
/* REMOVED --> SOCIAL LOGIN ROUTES
/*
Route::get('login/social/{provider}', 'Auth\SocialController@redirect');
Route::get('login/social/callback/{provider}', 'Auth\SocialController@callback');
*/

// Index (Instructions)
Route::get('/', 'API\v1\APIController@index');

// V1
Route::prefix('v1')->group(function () {
    Route::get('/', 'API\v1\APIController@v1')->middleware('client');
    Route::group(['prefix' => 'interests'], function(){
        Route::get('list', 'API\v1\InterestAPIController@getInterests')->name('api.v1.interests.get');
        Route::get('interestlocations', 'API\v1\InterestAPIController@getInterestLocations')->name('api.v1.interests.interestLocations');
        Route::post('/join', 'API\v1\InterestAPIController@joinCommunity')->middleware('client')->name('api.v1.interests.joincommunity');
        Route::post('/leave', 'API\v1\InterestAPIController@leaveCommunity')->middleware('client')->name('api.v1.interests.leavecommunity');
    });
    Route::group(['prefix' => 'locations'], function(){
        Route::get('list/{country?}/{state?}', 'API\v1\LocationAPIController@getLocations')->name('api.v1.locations.get');
    });
});

Route::fallback(function(){
    return response()->json([
        'message' => 'Not Found'
    ], 404);
});