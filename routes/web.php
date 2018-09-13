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

// detail comment
Route::get('/user/history-comment/{param}/view','UserhistoryController@comment_detail')->name('user-history-comment');

// detail inform
Route::get('/user/history-inform/{param}/view','UserhistoryController@inform_detail')->name('user-history-inform');

// detail complaint
Route::get('/user/history-complaint/{param}/view','UserhistoryController@complaint_detail')->name('user-history-complaint');

// list news
Route::get('/list-news','NewsController@index')->name('list-news');
Route::post('/list-news','NewsController@change_page')->name('list-news-change');


// for redirect to facebook auth.
Route::get('auth/login/facebook', 'IndexController@facebookAuthRedirect');
// facebook call back after login success.
Route::get('auth/login/facebook/index', 'IndexController@facebookSuccess');
// for redirect to logout auth.
Route::get('auth/login/logout', 'IndexController@facebooklogout');

// inform
Route::resource('/form/inform', 'InformController');

// commentform
Route::resource('/form/commentform', 'CommentformController');

// complaintform
Route::resource('/form/complaintform', 'ComplaintformController');

Route::get('/register', function () {})->name('register');

Route::get('/login', 'LoginController@index')->name('login');
Route::post('/login/check_login', 'LoginController@store')->name('login/check_login');
Route::get('/login/logout', 'LoginController@logout')->name('logout');

// Main Admin
Route::get('/admin', function () {
    return redirect('/admin/dashboard');
});
// Dashboard
Route::get('/admin/dashboard', 'DashboardController@index')->name('dashboard');

// Mn Administrator
Route::resource('/admin/administrator', 'AdministratorController');

// Reply inform
Route::resource('/admin/reply-inform', 'ReplyInformController');
Route::post('/admin/update-reply-inform', 'ReplyController@inform');

// Reply Comment
Route::resource('/admin/reply-comment', 'ReplyCommentController');
Route::post('/admin/update-reply-comment', 'ReplyController@comment');

// Reply Complaint
Route::resource('/admin/reply-complaint', 'ReplyComplaintController');
Route::post('/admin/update-reply-complaint', 'ReplyController@complaint');

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

// Global api
Route::get('/api/province', 'GlobalApiController@province')->name('api-province');
Route::get('/api/district/{id}', 'GlobalApiController@district')->name('api-district');
Route::get('/api/subdistrict/{id}', 'GlobalApiController@subdistrict')->name('api-subdistrict');
Route::get('/api/user-detail', 'GlobalApiController@user_detail')->name('api-user-detail');
// Route::get('/api/user-nofti', 'GlobalApiController@user_nofti')->name('api-user-nofti');
Route::post('/api/user-nofti', 'GlobalApiController@user_nofti')->name('api-user-nofti');
// check user auth
Route::get('/api/check-auth', 'GlobalApiController@check_auth')->name('api-check-auth');


Route::get('/test-excel', 'TestController@export')->name('test-export');