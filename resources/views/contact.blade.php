@extends('master.web-app')

@section('title', $title )

@section('content')
<div class="">
    <section id="contact">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <div class="logo-top">
                    <img src="{{ url('frontend-assets/assets/icon/logo.png') }}" class="img-responsive center-block">
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 10px;">
                <button class="btn btn-default btn-block knowledge-btn" data-toggle="collapse" data-target="#demo"> <i class="fa fa-address-book-o" aria-hidden="true"></i> ติดต่อหน่วยงาน</button>
                <div id="demo" class="collapse tooltip-contact">
                    ที่อยู่ เลขที่ ๑๐ ถนนเทียมร่วมมิตร แขวงห้วยขวาง เขตห้วยขวาง กรุงเทพมหานคร ๑๐๓๑๐ E-mail:webmaster@m-culture.go.th สายด่วนวัฒนธรรม ๑๗๖๕
                </div>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 10px;">
                <button class="btn btn-default btn-block knowledge-btn"> <i class="fa fa-map" aria-hidden="true"></i> แผนที่ </button>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 10px;">
                <button class="btn btn-default btn-block knowledge-btn"> <i class="fa fa-phone" aria-hidden="true"></i> สายด่วน 1765</button>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 10px;">
                <a href="https://www.m-culture.go.th/th/intro.html" target="_blank">
                    <button class="btn btn-default btn-block knowledge-btn"> <i class="fa fa-edge" aria-hidden="true"></i> Website</button>
                </a>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 10px;">
                <a href="https://www.facebook.com/ThaiMCulture">
                    <button class="btn btn-default btn-block knowledge-btn"> <i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</button>
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
