<!doctype html>
<html lang="en">

<head>
    <title>MCulture - @yield('title')</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	{{ \AppHelper::instance()->gen_script('css','assets/vendor/bootstrap/css/bootstrap.min.css') }}
	{{ \AppHelper::instance()->gen_script('css','assets/vendor/font-awesome/css/font-awesome.min.css') }}
	{{ \AppHelper::instance()->gen_script('css','assets/vendor/linearicons/style.css') }}
	{{ \AppHelper::instance()->gen_script('css','assets/vendor/chartist/css/chartist-custom.css') }}
	{{ \AppHelper::instance()->gen_script('css','assets/vendor/jquerytagsinput/dist/jquery.tagsinput.min.css') }}
	<!-- VENDOR CSS DATATABLE -->
	{{ \AppHelper::instance()->gen_script('css','assets/vendor/datatables/jquery.dataTables.css') }}
	{{ \AppHelper::instance()->gen_script('css','assets/vendor/datatables/buttons.dataTables.min.css') }}
	<!-- VENDOR CSS DATETIMERANGE -->
	{{ \AppHelper::instance()->gen_script('css','assets/vendor/daterangepicker/daterangepicker.css') }}
	<!-- MAIN CSS -->
	{{ \AppHelper::instance()->gen_script('css','assets/css/main.css') }}
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	{{ \AppHelper::instance()->gen_script('css','assets/css/demo.css') }}
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Niramit:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/favicon.png') }}">
</head>

<body>
<div class="preloader-wrapper">
    <div class="preloader">
        <img src="{{ asset('assets/img/preloader.gif') }}" alt="">
    </div>
</div>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="{{ url('/admin') }}"> MCulture </a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						@if (\Cookie::get('mcul_role') == 1 || \Cookie::get('mcul_role') == 2 )
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown" aria-expanded="false">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger notifications-count">5</span>
							</a>
							<ul class="dropdown-menu notifications">

							</ul>
						</li>
						@endif
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ asset('assets/img/user.png') }}" class="img-circle" alt="Avatar"> <span> {{ \AppHelper::instance()->get_admin_name() }} </span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('logout') }}"><i class="lnr lnr-exit"></i> <span>ออกจากระบบ</span></a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
				<nav>
					<ul class="nav">
						@if (\Cookie::get('mcul_role') == 1 )
							<li><a href="{{ url('/admin/administrator') }}" class="{{ (strpos(url()->current(),'administrator') ) ? 'active' : '' }}"><i class="lnr lnr-user"></i> <span>ผู้ดูแลระบบ</span></a></li>
						@endif
						@if (\Cookie::get('mcul_role') == 1 || \Cookie::get('mcul_role') == 2 )
						<li>
							<a href="#subPage" class="reply-main" data-toggle="collapse"><i class="lnr lnr-inbox"></i> <span>ตอบกลับ</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPage" class="collapse reply-sub">
								<ul class="nav">
									<li class="reply"><a style="font-size: 14px;" href="{{ url('/admin/reply-recommend') }}" class="{{ (strpos(url()->current(),'reply-recommend') ) ? 'active' : '' }}">ตอบกลับข้อมูลการ แนะนำ/ติชม</a></li>
									<li class="reply"><a style="font-size: 14px;" href="{{ url('/admin/reply-complaint') }}" class="{{ (strpos(url()->current(),'reply-complaint') ) ? 'active' : '' }}">ตอบกลับข้อมูลการ ร้องเรียน/ร้องทุกข์</a></li>
									<li class="reply"><a style="font-size: 14px;" href="{{ url('/admin/reply-other') }}" class="{{ (strpos(url()->current(),'reply-other') ) ? 'active' : '' }}">ตอบกลับข้อมูลเรื่องอื่นๆ</a></li>
								</ul>
							</div>
						</li>
						@endif
						@if (\Cookie::get('mcul_role') == 1 || \Cookie::get('mcul_role') == 3 )
						<li>
							<a href="#subPages" class="report-main" data-toggle="collapse"><i class="lnr lnr-file-empty"></i> <span>รายงาน</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse report-sub">
								<ul class="nav">
									<li class="report"><a style="font-size: 14px;" href="{{ url('/admin/report-user-fb') }}" class="{{ (strpos(url()->current(),'report-user-fb') ) ? 'active' : '' }}">รายชื่อและข้อมูลผู้ที่เข้าสู่ระบบด้วย Facebook</a></li>
									<li class="report"><a style="font-size: 14px;" href="{{ url('/admin/report-user-nm') }}" class="{{ (strpos(url()->current(),'report-user-nm') ) ? 'active' : '' }}">รายชื่อข้อมูลผู้ที่ส่งเรื่องทั้งหมด (แบบไม่ได้ Login ด้วย Facebook)</a></li>
									<li class="report"><a style="font-size: 14px;" href="{{ url('/admin/report-all') }}" class="{{ (strpos(url()->current(),'report-all') ) ? 'active' : '' }}">เรื่องทั้งหมดที่ได้รับข้อมูลจากประชาชน (ทุกหัวข้อ)</a></li>
									<li class="report"><a style="font-size: 14px;" href="{{ url('/admin/report-recommend') }}" class="{{ (strpos(url()->current(),'report-recommend') ) ? 'active' : '' }}">ข้อมูลการแนะนำ/ติชม ทั้งหมด</a></li>
									<li class="report"><a style="font-size: 14px;" href="{{ url('/admin/report-complaint') }}" class="{{ (strpos(url()->current(),'report-complaint') ) ? 'active' : '' }}">ข้อมูลการร้องเรียน/ร้องทุกข์ ทั้งหมด</a></li>
									<li class="report"><a style="font-size: 14px;" href="{{ url('/admin/report-other') }}" class="{{ (strpos(url()->current(),'report-other') ) ? 'active' : '' }}">ข้อมูลเรื่องอื่นๆทั้งหมด</a></li>
									<li class="report"><a style="font-size: 14px;" href="{{ url('/admin/report-replyed') }}" class="{{ (strpos(url()->current(),'report-replyed') ) ? 'active' : '' }}">รายการทั้งหมดที่ตอบกลับแล้ว</a></li>
									<li class="report"><a style="font-size: 14px;" href="{{ url('/admin/report-unreply') }}" class="{{ (strpos(url()->current(),'report-unreply') ) ? 'active' : '' }}">รายการที่ยังไม่ได้ตอบกลับ</a></li>
									<li class="report"><a style="font-size: 14px;" href="{{ url('/admin/report-unread') }}" class="{{ (strpos(url()->current(),'report-unread') ) ? 'active' : '' }}">รายการที่ยังไม่ได้อ่าน</a></li>
								</ul>
							</div>
						</li>
						@endif
						<li>
							<a href="#subPagess" class="km-main" data-toggle="collapse"><i class="lnr lnr-graduation-hat"></i><span>ความรู้</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPagess" class="collapse km-sub">
								<ul class="nav">
									<li class="km"><a style="font-size: 14px;" href="{{ url('/km/rituals') }}" class="{{ (strpos(url()->current(),'rituals') ) ? 'active' : '' }}"> ฐานข้อมูลประเพณีท้องถิ่น </a></li>
									<li class="km"><a style="font-size: 14px;" href="{{ url('/km/tradition') }}" class="{{ (strpos(url()->current(),'tradition') ) ? 'active' : '' }}">ประเพณี</a></li>
									<li class="km"><a style="font-size: 14px;" href="{{ url('/km/folkart') }}" class="{{ (strpos(url()->current(),'folkart') ) ? 'active' : '' }}">ศิลปะพื้นถิ่น</a></li>
									<li class="km"><a style="font-size: 14px;" href="{{ url('/km/thailitdir') }}" class="{{ (strpos(url()->current(),'thailitdir') ) ? 'active' : '' }}">ข้อมูลนามานุกรมวรรณคดีไทย</a></li>
								</ul>
							</div>
						</li>
						<li><a href="{{ url('/km/hilight') }}" class="{{ (strpos(url()->current(),'hilight') ) ? 'active' : '' }}"><i class="lnr lnr-graduation-hat"></i> <span>ไฮไลท์</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
		<div class="main">
			<!-- MAIN CONTENT -->
			<div class="main-content">
				<div class="container-fluid">
					<!-- OVERVIEW -->
					<div class="panel panel-headline">
						<div class="panel-heading">
							<h3 class="panel-title">@yield('header')</h3>
						</div>
						<div class="panel-body">
							<div class="row">
                                <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
									@yield('content')
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- END MAIN CONTENT -->
		</div>
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright">&copy; 2018 Mculture. All Rights Reserved.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/jquery/jquery.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/bootstrap/js/bootstrap.min.js') }}

	{{ \AppHelper::instance()->gen_script('js','assets/scripts/sweetalert.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/scripts/loadingoverlay.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/jquerytagsinput/dist/jquery.tagsinput.min.js') }}

	<!-- VENDOR CSS DATATABLE -->
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/datatables/jquery.dataTables.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/datatables/dataTables.buttons.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/datatables/buttons.flash.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/datatables/jszip.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/datatables/pdfmake.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/datatables/vfs_fonts.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/datatables/buttons.html5.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/datatables/buttons.print.min.js') }}

	<!-- VENDOR CSS DATETIMERANGE -->	
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/daterangepicker/moment.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/daterangepicker/daterangepicker.min.js') }}

	{{ \AppHelper::instance()->gen_script('js','assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/jquery.easy-pie-chart/jquery.easypiechart.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/chartist/js/chartist.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/scripts/klorofil-common.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/scripts/config.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/scripts/main.js') }}
</body>

</html>
