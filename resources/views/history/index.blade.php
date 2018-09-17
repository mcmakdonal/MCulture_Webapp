@extends('master.web-app')

@section('title', $title )

@section('content')
<div class="container">
    <section id="history">

        <div id="narrow-browser-alert" class="" style="margin-top: 15px;">
            <div class="" role="tabpanel">
                <ul id="myTab" class="nav nav-tabs nav-tabs-responsive text-center" role="tablist">
                    <li role="presentation" class="active" style="width: 33.33%">
                        <a href="#comment" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                            <span class="text">ติชม</span>
                        </a>
                    </li>
                    <li role="presentation" class="next" style="width: 33.33%">
                        <a href="#inform" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile">
                            <span class="text">ให้ข้อมูล</span>
                        </a>
                    </li>
                    <li role="presentation" style="width: 33.33%">
                        <a href="#complaint" role="tab" id="samsa-tab" data-toggle="tab" aria-controls="samsa">
                            <span class="text">ร้องเรียน</span>
                        </a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="comment" aria-labelledby="home-tab">
                        <div class="list-group">
                            @foreach($list->comment_data as $k => $v)
                                @php
                                    $read = ($v->cmdata_read == "R")? 'fa fa-eye' : 'fa fa-eye-slash';
                                    $reply = ($v->cmdata_reply == "A")? 'fa fa-commenting' : 'fa fa-comment';
                                    $id = Crypt::encrypt($v->cmdata_id);
                                @endphp
                                <a href="{{ url('/user/history-comment/'.$id.'/view') }}" class="list-group-item">
                                    {{$k + 1}}. {{$v->cmdata_name}} 
                                    <span class="admin-read"> <i class="{{$read}}" aria-hidden="true"></i> </span>
                                    <span class="admin-read"> <i class="{{$reply}}" aria-hidden="true"></i> </span>
                                <a>
                            @endforeach
                        </div> 
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="inform" aria-labelledby="profile-tab">
                        <div class="list-group">
                            @foreach($list->inform_data as $k => $v)
                                @php
                                    $read = ($v->ifdata_read == "R")? 'fa fa-eye' : 'fa fa-eye-slash';
                                    $reply = ($v->ifdata_reply == "A")? 'fa fa-commenting' : 'fa fa-comment';
                                    $id = Crypt::encrypt($v->ifdata_id);
                                @endphp
                                <a href="{{ url('/user/history-inform/'.$id.'/view') }}" class="list-group-item">
                                    {{$k + 1}}. {{$v->ifdata_name}} 
                                    <span class="admin-read"> <i class="{{$read}}" aria-hidden="true"></i> </span>
                                    <span class="admin-read"> <i class="{{$reply}}" aria-hidden="true"></i> </span>
                                <a>
                            @endforeach
                        </div> 
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="complaint" aria-labelledby="dropdown1-tab">
                        <div class="list-group">
                            @foreach($list->complaint_data as $k => $v)
                                @php
                                    $read = ($v->cpdata_read == "R")? 'fa fa-eye' : 'fa fa-eye-slash';
                                    $reply = ($v->cpdata_reply == "A")? 'fa fa-commenting' : 'fa fa-comment';
                                    $txt = ($v->cptype_id == 1)? $v->cpdata_storename : $v->cpdata_name;
                                    $id = Crypt::encrypt($v->cpdata_id);
                                @endphp
                                <a href="{{ url('/user/history-complaint/'.$id.'/view') }}" class="list-group-item">
                                    {{$k + 1}}. {{$txt}} 
                                    <span class="admin-read"> <i class="{{$read}}" aria-hidden="true"></i> </span>
                                    <span class="admin-read"> <i class="{{$reply}}" aria-hidden="true"></i> </span>
                                <a>
                            @endforeach
                        </div> 
                    </div>
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
@endsection