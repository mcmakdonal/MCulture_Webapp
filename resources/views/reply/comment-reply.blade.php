@extends('master.layout')

@section('title', $title )

@section('header', $header )

@section('content')

{!! Form::open(['url' => '/admin/reply-comment/'.$content->cmdata_id,'class' => 'form-auth-small', 'method' => 'put'] ) !!}
<div class="row">
    <div class="col-md-12 col-xs-12 col-sm-12">
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif
    </div>

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
        <h3 class="text-center">ส่วนของผู้ดูแลระบบ</h3>
    </div>

    <div class="col-md-12 col-xs-12 col-sm-12">
        <ul class="list-unstyled todo-list">
            <li>
                @foreach($content->reply as $reply)
                    <div class="row">
                        <div class="col-md-2">
                            <button type="button" class="btn btn-warning center-block edit-reply" data-class="inform" data-id="{{$reply->reply_id}}">แก้ไข</button>
                            <label class="text-center">ตอบกลับโดย : {{$reply->cmreply_by_name}}</label>
                        </div>
                        <div class="col-md-10">
                            <div id="reply_{{$reply->reply_id}}" style="display: block;word-wrap: break-word;">
                                {{$reply->cmdetail_reply}}
                            </div>
                        </div>
                    </div>
                    <hr />
                @endforeach
            </li>
        </ul>
    </div>

    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="CMDATA_DETAILREPLY" class="control-label">ตอบกลับ : </label>
            <textarea class="form-control" style="resize : vertical;" rows="3" id="CMDATA_DETAILREPLY" name="CMDATA_DETAILREPLY" required></textarea>
        </div>
    </div>

    <div class="col-md-12 col-xs-12 col-sm-12">
        <input type="hidden" value="{{ $content->device_token }}" name="device_token">
        <button type="submit" class="btn btn-success">ตอบกลับ</button>
        <?=link_to('/admin/reply-comment', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null);?>
    </div>
</div>

{!! Form::close() !!}

<!-- Modal -->
<div class="modal fade" id="nofti-reply" role="dialog">
    <div class="modal-dialog">
    {!! Form::open(['url' => '/admin/update-reply-comment','class' => 'form-auth-small', 'method' => 'post']) !!}
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" style="color: black;">แก้ไขการตอบกลับ</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="" class="control-label">ตอบกลับ : </label>
                        <input type="hidden" class="form-control" name="REPLY_ID" id="REPLY_ID" value="">
                        <input type="hidden" value="{{ $content->device_token }}" name="device_token">
                        <textarea class="form-control" style="resize : vertical;" rows="3" id="CMDATA_DETAILREPLY" name="CMDATA_DETAILREPLY" required></textarea>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success">ตอบกลับ</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
        </div>
    </div>
    {!! Form::close() !!}
    </div>
</div>


 @endsection