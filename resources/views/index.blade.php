@extends('master.web-app')

@section('title', $title )

@section('content')
<div class="container">
    <section id="index-logo">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <div class="logo-top">
                    <img src="{{ url('frontend-assets/assets/icon/logo.png') }}" class="img-responsive center-block">
                </div>
            </div>
        </div>
    </div>

    <section id="error">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
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
    </section>

    <section id="index-menu">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <div id="img-block" class="center-block">
                    <a href="{{ url('/form/commentform') }}">
                        <img class="img-responsive comment" src="/frontend-assets/assets/icon/comment.png">
                    </a>
                    <a href="{{ url('/form/inform') }}">
                        <img class="img-responsive info" src="/frontend-assets/assets/icon/info.png">
                    </a>
                    <a href="{{ url('/form/complaintform') }}">
                        <img class="img-responsive complaint" src="/frontend-assets/assets/icon/complaint.png">
                    </a>
                    <a href="{{ url('list-news') }}">
                        <img class="img-responsive news" src="/frontend-assets/assets/icon/news.png">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="index-contact">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <a href="{{ url('user/contact') }}">
                    <a href="{{ url('/contact') }}"><h3 class="text-center">ติดต่อสอบถาม</h3></a>
                </a>
            </div>
        </div>
    </section>

    <section id="index-fb">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                @if (\AppHelper::instance()->check_login_fb())
                    <a href="{{ url('auth/login/logout') }}">
                        <img class="img-responsive center-block fb-img" src="/frontend-assets/assets/imgs/out.png">
                    </a>
                @else
                    <a href="{{ url('auth/login/facebook') }}">
                        <img class="img-responsive center-block fb-img" src="/frontend-assets/assets/imgs/fb.png">
                    </a>
                @endif
            </div>
        </div>
    </section>

    @include('shared.modal-register')
    @include('shared.modal-nofti')
    
</div>
@endsection

@section('script')
    @if (\Cookie::get('USER_FULLNAME'))
        <script>
            $(document).ready(function(){
                init_profile();
            });
        </script>
    @endif
    @if (session('status'))
        <script>
            swal("Update Profile Success");
        </script>
    @endif

@endsection
