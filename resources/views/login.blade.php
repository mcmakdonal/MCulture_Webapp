<!doctype html>
<html lang="en" class="fullscreen-bg">

<head>
    <title>MCulture - เข้าสู่ระบบ</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" href="assets/vendor/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="assets/vendor/linearicons/style.css">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="assets/css/login_main.css">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="assets/css/demo.css">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" sizes="96x96" href="assets/img/favicon.png">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<div class="vertical-align-wrap">
			<div class="vertical-align-middle">
				<div class="auth-box ">
					<div class="left">
						<div class="content">
							<div class="header">
								<div class="logo text-center"><img class="img-responsive center-block" src="{{ asset('frontend-assets\assets\icon\logo.png')}}" alt="Klorofil Logo"></div>
								@if (session('status'))
									<div class="alert alert-danger">
										{{ session('status') }}
									</div>
								@endif
							</div>
							{!! Form::open(['route' => 'login/check_login','class' => 'form-auth-small', 'method' => 'post']) !!}
								<div class="form-group">
									<label for="username" class="control-label sr-only">ชื่อผู้ใช้งานระบบ : </label>
									<input type="text" class="form-control" id="username" name="username" value="" placeholder="ชื่อผู้ใช้งานระบบ" required>
								</div>
								<div class="form-group">
									<label for="password" class="control-label sr-only">รหัสผ่าน : </label>
									<input type="password" class="form-control" id="password" name="password" value="" placeholder="รหัสผ่าน" required>
								</div>
                                @csrf
								<button type="submit" class="btn btn-primary btn-lg btn-block">เข้าสู่ระบบ</button>
							{!! Form::close() !!}
						</div>
					</div>
					<div class="right">
						<div class="overlay"></div>
						<div class="content text">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
						</div>
					</div>
					<div class="clearfix"></div>
				</div>
			</div>
		</div>
	</div>
	<!-- END WRAPPER -->
    <script src="assets/vendor/jquery/jquery.min.js"></script>
    <!-- <script src="assets/scripts/main.js"></script> -->
</body>

</html>
