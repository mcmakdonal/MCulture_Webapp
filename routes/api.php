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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


// Global api
Route::get('/province', 'GlobalApiController@province')->name('api-province');
Route::get('/district/{id}', 'GlobalApiController@district')->name('api-district');
Route::get('/subdistrict/{id}', 'GlobalApiController@subdistrict')->name('api-subdistrict');
Route::get('/user-detail', 'GlobalApiController@user_detail')->name('api-user-detail');
// Route::get('/api/user-nofti', 'GlobalApiController@user_nofti')->name('api-user-nofti');
Route::post('/user-nofti', 'GlobalApiController@user_nofti')->name('api-user-nofti');
// check user auth
Route::get('/check-auth', 'GlobalApiController@check_auth')->name('api-check-auth');
// sub type
Route::get('/sub-type','GlobalApiController@sub_type');
// get_admissionfees
Route::get('/get-admissionfees','GlobalApiController@get_admissionfees');
// get_organizations
Route::get('/get-organizations','GlobalApiController@get_organizations');