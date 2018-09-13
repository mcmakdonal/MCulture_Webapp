@extends('master.web-app')

@section('title', $title )

@section('content')
<div class="container">
    <section id="history">
        <div class="row">
            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">ประเภท : </label>
                    <input type="text" class="form-control" id="" name="" value="{{$content->cmtype_name}}" placeholder="หัวข้อ" readonly>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">หัวข้อ : </label>
                    <input type="text" class="form-control" id="" name="" value="{{$content->cmdata_name}}" placeholder="หัวข้อ" readonly>
                </div>
            </div>


            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">แสดงความคิดเห็น/รายละเอียด : </label>
                    <textarea class="form-control" style="resize : vertical;" rows="3" id="" name="" readonly>{{$content->cmdata_details}}</textarea>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">ขื่อบุคลากร : </label>
                    <input type="text" class="form-control" name="" id="" value="{{$content->cmdata_personname}}" readonly>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <hr />
                <h3 class="text-center">ข้อมูลผู้แจ้ง</h3>
            </div>

            <div class="col-md-4 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">ชื่อ-นามสกุล : </label>
                    <input type="text" class="form-control" name="" id="" value="{{$content->user_fullname}}" readonly>
                </div>
            </div>

            <div class="col-md-4 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">อีเมล : </label>
                    <input type="text" class="form-control" name="" id="" value="{{$content->user_email}}" readonly>
                </div>
            </div>

            <div class="col-md-4 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">หมายเลขโทรศัพท์ : </label>
                    <input type="text" class="form-control" name="" id="" value="{{$content->user_phonenumber}}" readonly>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <hr />
                <h3 class="text-center">การตอบกลับ</h3>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <ul class="list-unstyled todo-list" style="color: white;">
                    <li>
                        @foreach($content->reply as $reply)
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <label class="text-center">ตอบกลับโดย : {{$reply->cmreply_by_name}}</label>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <div id="reply_{{$reply->reply_id}}" style="display: block;word-wrap: break-word;">
                                        {{$reply->cmdetail_reply}}
                                    </div>
                                </div>
                            </div>
                            <hr />
                        @endforeach
                        @if(count($content->reply) == 0)
                            <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <p class="text-center">ยังไม่มีการตอบกลับ</p>
                                </div>
                            </div>
                            <hr />
                        @endif
                    </li>
                </ul>
            </div>

        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12" style="margin-top: 10px;bottom: 15px;">
                <a href="{{ url()->previous() }}">
                    <button class="btn btn-default btn-block submit-color"> <i class="fa fa-arrow-left" aria-hidden="true"></i> </button>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
