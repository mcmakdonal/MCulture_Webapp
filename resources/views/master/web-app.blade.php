<!DOCTYPE html>
<html lang="en">
<head>
    <title>MCulture - @yield('title')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/css/bootstrap.min.css') }}
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/css/component.css') }}
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/css/main.css') }}
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/vendor/font-awesome/css/font-awesome.min.css') }}
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/vendor/select2/select2.min.css') }}
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Pridi:300,400,600,700" rel="stylesheet">
    <!-- DATETIME -->
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css') }}
</head>
<body>

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a class="sub-menu" onclick="init_profile();"> <img src="{{ url('frontend-assets/assets/icon/m_user.png') }}" class="img-responsive"> ข้อมูลส่วนตัว</a>
  <a class="sub-menu" href="{{ url('/user/history') }}"> <img src="{{ url('frontend-assets/assets/icon/m_arrow.png') }}" class="img-responsive"> ประวัติการตอบกลับ</a>
  <a class="sub-menu" onclick="init_nofti();"> <img src="{{ url('frontend-assets/assets/icon/m_ring.png') }}" class="img-responsive"> ตั้งค่าการแจ้งเตือน</a>
  <a class="sub-menu" href="{{ url('/auth/login/logout') }}">  <img src="{{ url('frontend-assets/assets/icon/m_key.png') }}" class="img-responsive"> ออกจากระบบ</a>
</div>

@if (\Cookie::get('mct_user_id') && Route::getCurrentRoute()->uri() == '/')
    <div id="user-img">
        <img src="{{ url('frontend-assets/assets/icon/m_user.png') }}" class="img-responsive" onclick="openNav()">
    </div>
@endif

<section id="main">
    @yield('content')
</section>

{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/jquery.min.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/bootstrap.min.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/loadingoverlay.min.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/sweetalert.min.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/config.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/main.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/input-file.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/vendor/select2/select2.min.js') }}
@yield('script')
</body>
</html>
