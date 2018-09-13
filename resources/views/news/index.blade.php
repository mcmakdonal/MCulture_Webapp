@extends('master.web-app')

@section('title', $title )

@section('content')
<div class="container">
    <section id="list-news">

        <div class="row" style="margin-top: 15px;">
            <div class="col-lg-2 col-md-2 col-xs-2 col-sm-2">
                <button type="button" class="btn prevpage" style="float: left;" {{ ($page == 1)? 'disabled' : '' }}><i class="fa fa-arrow-circle-left" aria-hidden="true"></i></button>
            </div>
            <div class="col-lg-8 col-md-8 col-xs-8 col-sm-8">
                <button type="button" class="btn center-block" style=""> กำลังแสดงหน้า : <span class="cpage">{{$page}}</span> จากทั้งหมด <span class="mpage">{{$total}}</span> </button>
            </div>
            <div class="col-lg-2 col-md-2 col-xs-2 col-sm-2">
                <button type="button" class="btn nextpage" style="float: right;"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i></button>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-bottom: 15px;margin-top: 15px;">
                <div class="list-group" id="block-list">
                    @foreach($content as $k => $v)
                    @php
                        $json = json_encode($v, JSON_UNESCAPED_UNICODE| JSON_UNESCAPED_SLASHES);
                    @endphp
                        <a href="#" class="list-group-item" onclick="opn_news({{$k}})"><i class="fa fa-bullhorn" aria-hidden="true"></i> {{ $v->activity_name }} </a>
                        <textarea class="hidden" id="txt{{$k}}">{{$json}}</textarea>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-top: 10px;bottom: 15px;">
                <a href="{{ url('/')}}">
                    <button class="btn btn-default btn-block submit-color"> <i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
                </a>
            </div>
        </div>

    </section>
</div>

@include('shared.modal-news')

@endsection
