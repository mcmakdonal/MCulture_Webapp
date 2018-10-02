@extends('master.web-app')

@section('title', $title )

@section('content')
<div class="">
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

    <section id="index-menu" class="hidden-md hidden-lg">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <div id="img-block" class="center-block">
                    <a href="{{ url('/hilight') }}">
                        <img class="img-responsive comment" src="/frontend-assets/assets/icon/menu_hilight.png">
                    </a>
                    <a href="{{ url('/recommend') }}">
                        <img class="img-responsive info" src="/frontend-assets/assets/icon/menu_recomment.png">
                    </a>
                    <a href="{{ url('/knowledges') }}">
                        <img class="img-responsive complaint" src="/frontend-assets/assets/icon/menu_knowledges.png">
                    </a>
                    <a href="{{ url('/contact') }}">
                        <img class="img-responsive news" src="/frontend-assets/assets/icon/menu_contact.png">
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="index-menu-full" class="hidden-xs hidden-sm">
        <div class="row">
            <div class="col-lg-3 col-md-3">
                <a href="{{ url('/recommend') }}">
                    <img class="img-responsive comment" src="/frontend-assets/assets/icon/menu_recomment.png">
                </a>
            </div>
            <div class="col-lg-3 col-md-3">
                <a href="{{ url('/hilight') }}">
                    <img class="img-responsive info" src="/frontend-assets/assets/icon/menu_hilight.png">
                </a>
            </div>
            <div class="col-lg-3 col-md-3">
                <a href="{{ url('/knowledges') }}">
                    <img class="img-responsive complaint" src="/frontend-assets/assets/icon/menu_knowledges.png">
                </a>
            </div>
            <div class="col-lg-3 col-md-3">
                <a href="{{ url('/contact') }}">
                    <img class="img-responsive news" src="/frontend-assets/assets/icon/menu_contact.png">
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

    <section id="index-help" class="hidden">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <a href="{{ url('/help') }}">
                    <a href="{{ url('/help') }}"><h3 class="text-center">ช่วยเหลือ</h3></a>
                </a>
            </div>
        </div>
    </section>

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
