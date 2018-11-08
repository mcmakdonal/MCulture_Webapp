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

// หน้าแรก
Route::get('/', 'IndexController@index')->name('index');
Route::post('/update-profile', 'IndexController@first_update');
Route::get('/contact', function () {
    $data = [
        'title' => 'Contact',
    ];
    return view('contact', $data);
});

// history user
Route::get('/user/history', 'UserhistoryController@index')->name('user-history');

// for redirect to facebook auth.
Route::get('auth/login/facebook', 'IndexController@facebookAuthRedirect');
// facebook call back after login success.
Route::get('auth/login/facebook/index', 'IndexController@facebookSuccess');
// for redirect to logout auth.
Route::get('auth/login/logout', 'IndexController@facebooklogout');

/////////////////////////// ROUTE Frontend /////////////////////////////////////////////

// recommend
Route::get('/recommend', 'IndexController@recommend');
Route::post('/recommend', 'IndexController@route_path');

// onepage
Route::get('/onepage', 'IndexController@onepage');
Route::post('/onepage', 'IndexController@store_onepage');

// Knowledges
Route::get('/knowledges', 'KnowledgesController@index');
Route::post('/knowledges', 'KnowledgesController@res_knowledge');

// Hilight
Route::get('/hilight', 'HilightController@index');
Route::post('/hilight', 'HilightController@res_hilight');

////////////////////// Login Manage ////////////////////////////////////////////////

Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login/check_login', 'LoginController@store')->name('login/check_login');
Route::get('/login/logout', 'LoginController@logout')->name('logout');

// Main Backend Profile
Route::get('/admin', 'AdminProfileController@index');
Route::put('/admin', 'AdminProfileController@update');

// Manage Administrator
Route::resource('/admin/administrator', 'AdministratorController');

// Reply Recommend
Route::get('/admin/reply-recommend', 'ReplyController@recommend');

// Reply Complaint
Route::get('/admin/reply-complaint', 'ReplyController@complaint');

// Reply Other
Route::get('/admin/reply-other', 'ReplyController@other');

// All Reply
Route::get('/admin/reply/{id}', 'ReplyController@view_reply');
// ตอบกลับ
Route::post('/admin/reply/{id}', 'ReplyController@reply');
// update แก้ไขการตอบกลับ
Route::put('/admin/reply', 'ReplyController@replyed');
// delete topic
Route::delete('/admin/remove-topic/{id}', 'ReplyController@remove_topic');

///////////////////////////////////////////// REPORT /////////////////////////////////////////////////////////

// Report User
Route::get('/admin/report-user-fb', 'ReportUserController@user_fb')->name('report-user-fb');
Route::post('/admin/report-user-fb', 'ReportUserController@user_fb');

Route::get('/admin/report-user-nm', 'ReportUserController@user_nm')->name('report-user-nm');
Route::post('/admin/report-user-nm', 'ReportUserController@user_nm');

// Report ทั้งหมด
Route::get('/admin/report-all', 'MakeReportController@index');
// Report ตอบกลับแล้ว
Route::get('/admin/report-replyed', 'MakeReportController@index');
// Report ยังไม่ตอบกลับแล้ว
Route::get('/admin/report-unreply', 'MakeReportController@index');
// Report ยังไม่ได้อ่าน
Route::get('/admin/report-unread', 'MakeReportController@index');
// Gen report
Route::post('/admin/report-generate', 'MakeReportController@generate');

// Report Recommend
Route::get('/admin/report-recommend', 'MakeReportController@recommend');
Route::post('/admin/report-recommend', 'MakeReportController@recommend_report');

// Report Complaint
Route::get('/admin/report-complaint', 'MakeReportController@complaint');
Route::post('/admin/report-complaint', 'MakeReportController@complaint_report');

// Report Other
Route::get('/admin/report-other', 'MakeReportController@other');
Route::post('/admin/report-other', 'MakeReportController@other_report');

/////////////////////////// Manage KM /////////////////////////////////////////////////////

// Main Admin
Route::get('/km', function () {
    return redirect('/km/rituals');
});

Route::resource('/km/rituals', 'KmRitualsController');
Route::resource('/km/tradition', 'KmTraditionController');
Route::resource('/km/folkart', 'KmFolkartController');
Route::resource('/km/thailitdir', 'KmThailitdirController');
Route::resource('/km/hilight', 'KmHilightController');

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
Route::get('/api/sub-type', 'GlobalApiController@sub_type');
// get_admissionfees
Route::get('/api/get-admissionfees', 'GlobalApiController@get_admissionfees');
// get noti
Route::get('/api/get-noti', 'GlobalApiController@get_noti');
// Mass admin
Route::get('/api/mass-admin', 'GlobalApiController@mass_admin');

////////////////////////////////////////////// TEST ///////////////////////////////////

Route::get('/session', function () {
    dd(session('field_edit'));
});

Route::get('/cookie', function () {
    // \Cookie::forget('USER_FULLNAME');
    // \Cookie::forget('USER_EMAIL');
    dd(\Cookie::get());
});

Route::get('/env', function () {
    phpinfo();
});
