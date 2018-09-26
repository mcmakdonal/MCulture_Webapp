<!DOCTYPE html>
<html lang="en">
<head>
    <title>MCulture - @yield('title')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- {{ \AppHelper::instance()->gen_script('css','frontend-assets/css/bootstrap.min.css') }} -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/css/component.css') }}
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/css/main.css') }}
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/css/modern_txt.css') }}
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/vendor/select2/select2.min.css') }}
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/vendor/bxslider/dist/jquery.bxslider.min.css') }}
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Pridi:300,400,600,700" rel="stylesheet">
    <!-- DATETIME -->
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/vendor/jquery-timepicker-addon/dist/jquery-ui.css') }}
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/vendor/jquery-timepicker-addon/dist/jquery-ui-timepicker-addon.css') }}
    {{ \AppHelper::instance()->gen_script('css','frontend-assets/vendor/font-awesome/css/font-awesome.min.css') }}
</head>
<body style="padding: 15px;">

<div id="mySidenav" class="sidenav">
  <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
  <a class="sub-menu" onclick="init_profile();"> <img src="{{ url('frontend-assets/assets/icon/m_user.png') }}" class="img-responsive"> ข้อมูลส่วนตัว</a>
  <a class="sub-menu" href="{{ url('/user/history') }}"> <img src="{{ url('frontend-assets/assets/icon/m_arrow.png') }}" class="img-responsive"> ประวัติการตอบกลับ</a>
  <a class="sub-menu" onclick="init_nofti();"> <img src="{{ url('frontend-assets/assets/icon/m_ring.png') }}" class="img-responsive"> ตั้งค่าการแจ้งเตือน</a>
  <a class="sub-menu" href="{{ url('/auth/login/logout') }}">  <img src="{{ url('frontend-assets/assets/icon/m_key.png') }}" class="img-responsive"> ออกจากระบบ</a>
</div>

@if (\Cookie::get('mct_user_id'))
    <div id="user-img" class="hidden-md hidden-lg">
        <img src="{{ url('frontend-assets/assets/icon/m_user.png') }}" class="img-responsive" onclick="openNav()">
    </div>
@endif

<section id="main" style="margin-bottom: 70px;">
    <div class="row">
        <div class="col-md-3 col-lg-3 hidden-xs hidden-sm" style="">
            <!-- It can be fixed with bootstrap affix http://getbootstrap.com/javascript/#affix-->
            <div id="sidebar" class="sidebar-nav">
                <h3>
                    <i class="fa fa-globe" aria-hidden="true"></i> M-Culture
                </h3>
                <ul class="nav nav-pills nav-stacked">
                    <li class="{{ (url()->current() === url('')) ? 'nav-active' : '' }}"><a href="{{ url('/') }}"><i class="fa fa-home" aria-hidden="true"></i> หน้าหลัก</a></li>
                    <li class="{{ (strpos(url()->current(),'recommend') ) ? 'nav-active' : '' }}"><a href="{{ url('/recommend') }}"><i class="fa fa-commenting-o" aria-hidden="true"></i> แนะนำ</a></li>
                    <li class="{{ (strpos(url()->current(),'hilight') ) ? 'nav-active' : '' }}"><a href="{{ url('/hilight') }}"><i class="fa fa-star" aria-hidden="true"></i> ไฮไลท์</a></li>
                    <li class="{{ (strpos(url()->current(),'knowledges') ) ? 'nav-active' : '' }}"><a href="{{ url('/knowledges') }}"><i class="fa fa-lightbulb-o" aria-hidden="true"></i> องค์ความรู้</a></li>
                    <li class="{{ (strpos(url()->current(),'contact') ) ? 'nav-active' : '' }}"><a href="{{ url('/contact') }}"><i class="fa fa-phone" aria-hidden="true"></i> ติดต่อ</a></li>
                </ul>

                @if (\Cookie::get('mct_user_id'))
                <h3>
                    <i class="fa fa-sliders" aria-hidden="true"></i> Setting User
                </h3>
                <ul class="nav nav-pills nav-stacked">
                    <li style="cursor: pointer;">
                        <a class="" onclick="init_profile();"> <img src="{{ url('frontend-assets/assets/icon/m_user.png') }}" class="img-responsive"> ข้อมูลส่วนตัว</a>
                    </li>
                    <li class="{{ (strpos(url()->current(),'/user/history') ) ? 'nav-active' : '' }}">
                        <a href="{{ url('/user/history') }}"> <img src="{{ url('frontend-assets/assets/icon/m_arrow.png') }}" class="img-responsive"> ประวัติการตอบกลับ</a>
                    </li>
                    <li style="cursor: pointer;">
                        <a onclick="init_nofti();"> <img src="{{ url('frontend-assets/assets/icon/m_ring.png') }}" class="img-responsive"> ตั้งค่าการแจ้งเตือน</a>
                    </li>
                    <li style="cursor: pointer;">
                        <a href="{{ url('/auth/login/logout') }}">  <img src="{{ url('frontend-assets/assets/icon/m_key.png') }}" class="img-responsive"> ออกจากระบบ</a>
                    </li>
                </ul>
                @endif

            </div>
        </div>
        <div class="col-md-9 col-lg-9 col-xs-12 col-sm-12">
            @yield('content')
        </div>
    </div>
</section>

<nav class="navbar navbar-fixed-bottom hidden-md hidden-lg" style="background-color: #C32191;">
    <div class="container-fluid">
        <div class="row">
            <ul class="nav-responsive">
                <li class="text-center {{ (url()->current() === url('')) ? 'nav-active' : '' }}">
                    <a href="{{ url('/') }}">
                        <div class="img-block">
                            <img src="{{ url('frontend-assets/assets/icon/nav_01.png') }}" class="img-responsive center-block img-icon">
                        </div>
                    </a>
                    <span>หน้าหลัก</span>
                </li>
                <li class="text-center {{ (strpos(url()->current(),'recommend') ) ? 'nav-active' : '' }}">
                    <a href="{{ url('/recommend') }}">
                        <div class="img-block">
                            <img src="{{ url('frontend-assets/assets/icon/nav_02.png') }}" class="img-responsive center-block img-icon">
                        </div>
                    </a>
                    <span>แนะนำ</span>
                </li>
                <li class="text-center {{ (strpos(url()->current(),'hilight') ) ? 'nav-active' : '' }}">
                    <a href="{{ url('/hilight') }}">
                        <div class="img-block">
                            <img src="{{ url('frontend-assets/assets/icon/nav_03.png') }}" class="img-responsive center-block img-icon">
                        </div>
                    </a>
                    <span>ไฮไลท์</span>
                </li>
                <li class="text-center {{ (strpos(url()->current(),'knowledges') ) ? 'nav-active' : '' }}">
                    <a href="{{ url('/knowledges') }}">
                        <div class="img-block">
                            <img src="{{ url('frontend-assets/assets/icon/nav_04.png') }}" class="img-responsive center-block img-icon">
                        </div>
                    </a>
                    <span>องค์ความรู้</span>
                </li>
                <li class="text-center {{ (strpos(url()->current(),'contact') ) ? 'nav-active' : '' }}">
                    <a href="{{ url('/contact') }}">
                        <div class="img-block">
                            <img src="{{ url('frontend-assets/assets/icon/nav_05.png') }}" class="img-responsive center-block img-icon">
                        </div>
                    </a>
                    <span>ติดต่อ</span>
                </li>
            </ul>
        </div>
    </div>
</nav>

@include('shared.modal-update-profile')
@include('shared.modal-nofti')

{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/jquery.min.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/bootstrap.min.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/loadingoverlay.min.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/sweetalert.min.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/vendor/josecebe-twbs-pagination/jquery.twbsPagination.min.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/vendor/bxslider/dist/jquery.bxslider.min.js') }}
<!-- {{ \AppHelper::instance()->gen_script('js','frontend-assets/js/config.js') }} -->
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/modern_txt.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/config.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/main.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/module.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/js/input-file.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/vendor/jquery-timepicker-addon/dist/jquery-ui.min.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/vendor/jquery-timepicker-addon/dist/jquery-ui-timepicker-addon.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/vendor/jquery-timepicker-addon/dist/jquery-ui-sliderAccess.js') }}
{{ \AppHelper::instance()->gen_script('js','frontend-assets/vendor/select2/select2.min.js') }}
@yield('script')
</body>
</html>
