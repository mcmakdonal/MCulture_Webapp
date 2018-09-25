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
	<link href="https://fonts.googleapis.com/css?family=Pridi:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets/img/apple-icon.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/favicon.png') }}">
</head>

<body>
<div class="preloader-wrapper">
    <div class="preloader">
        <img src="{{ asset('assets/img/preloader.gif') }}" alt="NILA">
    </div>
</div>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		<nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="{{ url('/admin/dashboard') }}"> MCulture </a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
				<div id="navbar-menu">
					<ul class="nav navbar-nav navbar-right">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle icon-menu" data-toggle="dropdown" aria-expanded="false">
								<i class="lnr lnr-alarm"></i>
								<span class="badge bg-danger">5</span>
							</a>
							<ul class="dropdown-menu notifications">
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>การแจ้งเตือนใหม่จากคุณศรีศักร วันทา</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>การแจ้งเตือนใหม่จากคุณรัตภพ สืบโมรา</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>การแจ้งเตือนใหม่จากคุณจักรกฤษ ไชวาน</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>การแจ้งเตือนใหม่จากคุณณัฐพล เสียงล้ำ</a></li>
								<li><a href="#" class="notification-item"><span class="dot bg-warning"></span>การแจ้งเตือนใหม่จากคุณเกียรติศัก วงษา</a></li>
								<li><a href="#" class="more">{{ url()->current() }}</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><img src="{{ asset('assets/img/user.png') }}" class="img-circle" alt="Avatar"> <span>Administrator</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
							<ul class="dropdown-menu">
								<li><a href="{{ route('logout') }}"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
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
						<li><a href="{{ url('/admin/administrator') }}" class="{{ (strpos(url()->current(),'administrator') ) ? 'active' : '' }}"><i class="lnr lnr-user"></i> <span>Administrator</span></a></li>
						<li>
							<a href="#subPage" data-toggle="collapse"><i class="lnr lnr-inbox"></i> <span>Reply</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPage" class="collapse ">
								<ul class="nav">
									<li class=""><a style="font-size: 12px;" href="{{ url('/admin/reply-inform') }}" class="{{ (strpos(url()->current(),'reply-inform') ) ? 'active' : '' }}">ตอบกลับข้อมูลการ แนะนำ/ติชม</a></li>
									<li class=""><a style="font-size: 12px;" href="{{ url('/admin/reply-comment') }}" class="{{ (strpos(url()->current(),'reply-comment') ) ? 'active' : '' }}">ตอบกลับข้อมูลการ ร้องเรียน/ร้องทุกข์</a></li>
									<li class=""><a style="font-size: 12px;" href="{{ url('/admin/reply-complaint') }}" class="{{ (strpos(url()->current(),'reply-complaint') ) ? 'active' : '' }}">ตอบกลับข้อมูลเรื่องอื่นๆ</a></li>
								</ul>
							</div>
						</li>
						<li>
							<a href="#subPages" data-toggle="collapse"><i class="lnr lnr-file-empty"></i> <span>Report</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
							<div id="subPages" class="collapse ">
								<ul class="nav">
									<li><a style="font-size: 12px;" href="{{ url('/admin/report-user-fb') }}" class="{{ (strpos(url()->current(),'report-user-fb') ) ? 'active' : '' }}">รายชื่อและข้อมูลผู้ที่เข้าสู่ระบบด้วย Facebook</a></li>
									<li><a style="font-size: 12px;" href="{{ url('/admin/report-user-nm') }}" class="{{ (strpos(url()->current(),'report-user-nm') ) ? 'active' : '' }}">รายชื่อข้อมูลผู้ที่ส่งเรื่องทั้งหมด (แบบไม่ได้ Login ด้วย Facebook)</a></li>
									<li><a style="font-size: 12px;" href="{{ url('/admin/report/1') }}" class="">เรื่องทั้งหมดที่ได้รับข้อมูลจากประชาชน (ทุกหัวข้อ)</a></li>
									<li><a style="font-size: 12px;" href="{{ url('/admin/report-inform') }}" class="">ข้อมูลการแนะนำ/ติชม ทั้งหมด</a></li>
									<li><a style="font-size: 12px;" href="{{ url('/admin/report-comment') }}" class="">ข้อมูลการร้องเรียน/ร้องทุกข์ ทั้งหมด</a></li>
									<li><a style="font-size: 12px;" href="{{ url('/admin/report-complaint') }}" class="">ข้อมูลเรื่องอื่นๆทั้งหมด</a></li>
									<li><a style="font-size: 12px;" href="{{ url('/admin/report/2') }}" class="">รายการทั้งหมดที่ตอบกลับแล้ว</a></li>
									<li><a style="font-size: 12px;" href="{{ url('/admin/report/3') }}" class="">รายการที่ยังไม่ได้ตอบกลับ</a></li>
									<li><a style="font-size: 12px;" href="{{ url('/admin/report/4') }}" class="">รายการที่ยังไม่ได้อ่าน</a></li>
								</ul>
							</div>
						</li>
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
				<p class="copyright">&copy; 2018 MC. All Rights Reserved.</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/jquery/jquery.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/vendor/bootstrap/js/bootstrap.min.js') }}

	{{ \AppHelper::instance()->gen_script('js','assets/scripts/sweetalert.min.js') }}
	{{ \AppHelper::instance()->gen_script('js','assets/scripts/loadingoverlay.min.js') }}

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
	{{ \AppHelper::instance()->gen_script('js','assets/scripts/main.js') }}
	<!-- {{ \AppHelper::instance()->gen_script('js','assets/css/demo.css') }} -->
</body>

</html>
