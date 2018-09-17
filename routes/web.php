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

/////////////////////////// ROUTE V2 /////////////////////////////////////////////

// recommend
Route::get('/recommend','RecommendController@index');
Route::post('/recommend','RecommendController@route_path');

// ---------------------------------------------- Recommend ---------------------------------------------- //

// recommend activity
Route::get('/recommend/activity','RecommendController@recommend_activity');
Route::post('/recommend/activity','RecommendController@recommend_activity_save');

// recommend activity
Route::get('/recommend/place','RecommendController@recommend_place');
Route::post('/recommend/place','RecommendController@recommend_place_save');

// recommend knowledge
Route::get('/recommend/knowledge','RecommendController@recommend_knowledge');
Route::post('/recommend/knowledge','RecommendController@recommend_knowledge_save');

// recommend service
Route::get('/recommend/service','RecommendController@recommend_service');
Route::post('/recommend/service','RecommendController@recommend_service_save');

// recommend employee
Route::get('/recommend/employee','RecommendController@recommend_employee');
Route::post('/recommend/employee','RecommendController@recommend_employee_save');

// recommend other
Route::get('/recommend/other','RecommendController@recommend_other');
Route::post('/recommend/other','RecommendController@recommend_other_save');

// ---------------------------------------------- Complaint ---------------------------------------------- //

// recommend improper-media
Route::get('/complaint/improper-media','ComplaintController@complaint_improper_media');
Route::post('/complaint/improper-media','ComplaintController@complaint_improper_media_save');

// recommend deviate
Route::get('/complaint/deviate','ComplaintController@complaint_deviate');
Route::post('/complaint/deviate','ComplaintController@complaint_deviate_save');

// recommend employee
Route::get('/complaint/employee','ComplaintController@complaint_employee');
Route::post('/complaint/employee','ComplaintController@complaint_employee_save');

// recommend commerce
Route::get('/complaint/commerce','ComplaintController@complaint_commerce');
Route::post('/complaint/commerce','ComplaintController@complaint_commerce_save');

// recommend religion
Route::get('/complaint/religion','ComplaintController@complaint_religion');
Route::post('/complaint/religion','ComplaintController@complaint_commerce_save');

// recommend culture
Route::get('/complaint/culture','ComplaintController@complaint_culture');
Route::post('/complaint/culture','ComplaintController@complaint_culture_save');

// recommend other
Route::get('/complaint/other','ComplaintController@complaint_other');
Route::post('/complaint/other','ComplaintController@complaint_other_save');

// ---------------------------------------------- Other ---------------------------------------------- //

// recommend improper-media
Route::get('/other/other','OtherController@other_other');
Route::post('/other/other','OtherController@other_other_save');


Route::get('/other',function (){
    return redirect('/recommend');
});

Route::get('/complaint',function (){
    return redirect('/recommend');
});

////////////////////////////////////////////// TEST ///////////////////////////////////


Route::get('/session', function () {
    dd(session('type'));
});