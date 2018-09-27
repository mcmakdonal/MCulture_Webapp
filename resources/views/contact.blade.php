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
                <button class="btn btn-default btn-block knowledge-btn"> <i class="fa fa-address-book-o" aria-hidden="true"></i> ติดต่อหน่วยงาน</button>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 10px;">
                <button class="btn btn-default btn-block knowledge-btn"> <i class="fa fa-phone" aria-hidden="true"></i> สายด่วน</button>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 10px;">
                <button class="btn btn-default btn-block knowledge-btn"> <i class="fa fa-comment" aria-hidden="true"></i> ให้ข้อมูล/ติชม</button>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 10px;">
                <h5 class="text-center">ติดตามเราได้ที่</h5>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 10px;">
                <button class="btn btn-default btn-block knowledge-btn"> <i class="fa fa-edge" aria-hidden="true"></i> Website</button>
            </div>

            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 10px;">
                <button class="btn btn-default btn-block knowledge-btn"> <i class="fa fa-facebook-square" aria-hidden="true"></i> Facebook</button>
            </div>

        </div>
    </div>
</div>
@endsection
