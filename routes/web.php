<?php

use Illuminate\Http\Request;

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

// Route::get('/', function () {
//     return view('welcome');
// });

// หน้าแรก
Route::get('/', 'IndexController@index')->name('index');
Route::post('/update-profile', 'IndexController@first_update');
Route::get('/contact', function () {
    $data = [
        'title' => 'Contact'
    ];
    return view('contact',$data);
});

// history user
Route::get('/user/history','UserhistoryController@index')->name('user-history');

// for redirect to facebook auth.
Route::get('auth/login/facebook', 'IndexController@facebookAuthRedirect');
// facebook call back after login success.
Route::get('auth/login/facebook/index', 'IndexController@facebookSuccess');
// for redirect to logout auth.
Route::get('auth/login/logout', 'IndexController@facebooklogout');

////////////////////// Login Manage ////////////////////////////////////////////////

Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login/check_login', 'LoginController@store')->name('login/check_login');
Route::get('/login/logout', 'LoginController@logout')->name('logout');

// Main Admin
Route::get('/admin', function () {
    return redirect('/admin/administrator');
});

// Manage Administrator
Route::resource('/admin/administrator', 'AdministratorController');

// Reply Recommend
Route::get('/admin/reply-recommend', 'ReplyController@recommend');

// Reply Complaint
Route::get('/admin/reply-complaint', 'ReplyController@complaint');

// Reply Other
Route::get('/admin/reply-other', 'ReplyController@other');

// All Reply
Route::get('/admin/reply/{id}', 'ReplyController@reply');

//////////////////////////////////////////////////////////////////////////////////////////////////////

// Report User
Route::get('/admin/report-user-fb', 'ReportUserController@user_fb')->name('report-user-fb');
Route::post('/admin/report-user-fb', 'ReportUserController@user_fb');

Route::get('/admin/report-user-nm', 'ReportUserController@user_nm')->name('report-user-nm');
Route::post('/admin/report-user-nm', 'ReportUserController@user_nm');

// Report Comment
Route::get('/admin/report-comment', 'ReportCommentController@comment')->name('report-comment');
Route::post('/admin/report-comment', 'ReportCommentController@comment');

// Report Inform
Route::get('/admin/report-inform', 'ReportInformController@inform')->name('report-inform');
Route::post('/admin/report-inform', 'ReportInformController@inform');

// Report Complaint
Route::get('/admin/report-complaint', 'ReportComplaintController@complaint')->name('report-complaint');
Route::post('/admin/report-complaint', 'ReportComplaintController@complaint');

// Report All recive
Route::get('/admin/report/{type}', 'MakeReportController@report');

// Report All reply
Route::get('/admin/report/{type}', 'MakeReportController@report');

// Report All not recive
Route::get('/admin/report/{type}', 'MakeReportController@report');

// Report All unread
Route::get('/admin/report/{type}', 'MakeReportController@report');

/////////////////////////// ROUTE /////////////////////////////////////////////

// recommend
Route::get('/recommend','IndexController@recommend');
Route::post('/recommend','IndexController@route_path');

// onepage
Route::get('/onepage','IndexController@onepage');
Route::post('/onepage','IndexController@store_onepage');

// Knowledges
Route::get('/knowledges','KnowledgesController@index');
Route::post('/knowledges','KnowledgesController@res_knowledge');


// Hilight
Route::get('/hilight','HilightController@index');
Route::post('/hilight','HilightController@res_hilight');

////////////////////////// API ////////////////////////////////////////////////////////////

// Global api
Route::get('/api/province', 'GlobalApiController@province')->name('api-province');
Route::get('/api/district/{id}', 'GlobalApiController@district')->name('api-district');
Route::get('/api/subdistrict/{id}', 'GlobalApiController@subdistrict')->name('api-subdistrict');
Route::get('/api/user-detail', 'GlobalApiController@user_detail')->name('api-user-detail');
// Route::get('/api/user-nofti', 'GlobalApiController@user_nofti')->name('api-user-nofti');
Route::post('/api/user-nofti', 'GlobalApiController@user_nofti')->name('api-user-nofti');
// check user auth
Route::get('/api/check-auth', 'GlobalApiController@check_auth')->name('api-check-auth');
// sub type
Route::get('/api/sub-type','GlobalApiController@sub_type');
// get_admissionfees
Route::get('/api/get-admissionfees','GlobalApiController@get_admissionfees');

////////////////////////////////////////////// TEST ///////////////////////////////////


Route::get('/session', function () {
    dd(session('field_edit'));
});

Route::get('/cookie', function () {
    // \Cookie::forget('USER_FULLNAME');
    // \Cookie::forget('USER_EMAIL');
    dd(\Cookie::get());
});