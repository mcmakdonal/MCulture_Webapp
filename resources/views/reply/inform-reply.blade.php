@extends('master.layout')

@section('title', $title )

@section('header', $header )

@section('content')

{!! Form::open(['url' => '/admin/reply-inform/'.$content->ifdata_id,'class' => 'form-auth-small', 'method' => 'put'] ) !!}
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
            <input type="text" class="form-control" id="" name="" value="{{$content->iftype_name}}" placeholder="" readonly>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">หัวข้อ : </label>
            <input type="text" class="form-control" id="" name="" value="{{$content->ifdata_name}}" placeholder="หัวข้อ" readonly>
        </div>
    </div>


    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">แสดงความคิดเห็น/รายละเอียด : </label>
            <textarea class="form-control" style="resize : vertical;" rows="3" id="" name="" readonly>{{$content->ifdata_details}}</textarea>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">จังหวัด : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->province_name}}" readonly>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">อำเภอ : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->district_name}}" readonly>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ตำบล : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->subdistrict_name}}" readonly>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">วันที่ : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->ifdata_date}}" readonly>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">เวลา : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->ifdata_times}}" readonly>
        </div>
    </div>   

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ค่าเข้าชม : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->ifdata_price}}" readonly>
        </div>
    </div>            

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">เวลาเปิด : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->ifdata_opentime}}" readonly>
        </div>
    </div>                

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">เวลาปิด : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->ifdata_closetime}}" readonly>
        </div>
    </div> 

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">Location : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->ifdata_location}}" readonly>
        </div>
    </div> 

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">Latitude : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->ifdata_latitude}}" readonly>
        </div>
    </div> 

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">Longitude : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->ifdata_longitude}}" readonly>
        </div>
    </div>             

    <div class="col-md-12 col-xs-12 col-sm-12">
        <hr />
        <h3 class="text-center">รูปภาพ</h3>
    </div>

    @foreach($content->images as $img)
        <div class="col-md-4 col-xs-6 col-sm-6">
            <div class="parent">
                <img src="@php echo $img->image_path @endphp" class="img-responsive">
            </div>
        </div>
    @endforeach

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
                            <label class="text-center">ตอบกลับโดย : {{$reply->ifreply_by_name}}</label>
                        </div>
                        <div class="col-md-10">
                            <div id="reply_{{$reply->reply_id}}" style="display: block;word-wrap: break-word;">
                                {{$reply->ifdetail_reply}}
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
            <label for="IFDATA_DETAILREPLY" class="control-label">ตอบกลับ : </label>
            <textarea class="form-control" style="resize : vertical;" rows="3" id="IFDATA_DETAILREPLY" name="IFDATA_DETAILREPLY" required></textarea>
        </div>
    </div>


    <div class="col-md-12 col-xs-12 col-sm-12">
        <input type="hidden" value="{{ $content->device_token }}" name="device_token">
        <button type="submit" class="btn btn-success">ตอบกลับ</button>
        <?=link_to('/admin/reply-inform', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null);?>
    </div>
</div>
{!! Form::close() !!}

<!-- Modal -->
<div class="modal fade" id="nofti-reply" role="dialog">
    <div class="modal-dialog">
    {!! Form::open(['url' => '/admin/update-reply-inform','class' => 'form-auth-small', 'method' => 'post']) !!}
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
                        <input type="hidden" value="{{ $content->device_token }}" name="device_token">
                        <input type="hidden" class="form-control" name="REPLY_ID" id="REPLY_ID" value="">
                        <textarea class="form-control" style="resize : vertical;" rows="3" id="IFDATA_DETAILREPLY" name="IFDATA_DETAILREPLY" required></textarea>
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