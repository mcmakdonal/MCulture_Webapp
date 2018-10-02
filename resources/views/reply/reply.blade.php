@extends('master.layout')

@section('title', $title )

@section('header', $header )

@section('content')

{!! Form::open(['url' => url()->current(),'class' => 'form-auth-small', 'method' => 'POST'] ) !!}
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

    @if(in_array("religion_id", Session::get('field_edit')))
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ประเภทศาสนา : </label>
            <input type="text" class="form-control" id="" name="" value="{{ $content->religion_name }}" placeholder="ประเภทศาสนา" disabled>
        </div>
    </div>
    @endif

    @if(in_array("organize_id", Session::get('field_edit')))
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">หน่วยงาน : </label>
            <input type="text" class="form-control" id="" name="" value="{{ $content->organize_name }}" placeholder="หน่วยงาน" disabled>
        </div>
    </div>
    @endif

    @if(in_array("commerce_type_id", Session::get('field_edit')))
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ประเภทสื่อ : </label>
            <input type="text" class="form-control" id="" name="" value="{{ $content->commerce_type_name }}" placeholder="ประเภทสื่อ" disabled>
        </div>
    </div>
    @endif

    @if(in_array("topic_title", Session::get('field_edit')))
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">หัวข้อ/เหตุการณ์ : </label>
            <input type="text" class="form-control" id="" name="" value="{{ $content->topic_title }}" placeholder="หัวข้อ/เหตุการณ์" disabled>
        </div>
    </div>
    @endif

    @if(in_array("business_name", Session::get('field_edit')))
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ชื่อร้าน : </label>
            <input type="text" class="form-control" id="" name="" value="{{ $content->business_name }}" placeholder="ชื่อร้าน" disabled>
        </div>
    </div>
    @endif

    @if(in_array("start_date", Session::get('field_edit')))
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">วันที่จัดกิจกรรม : </label>
            @php
            $date = $content->start_date;
            if($date== ""){
                $date = "";
            }else{
                $date = \AppHelper::instance()->Bt_date($date);
            }
            @endphp
            <input type="text" class="form-control" id="" name="" value="{{ $date }}" disabled>
        </div>
    </div>
    @endif

    @if(in_array("end_date", Session::get('field_edit')))
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ถึงวันที่ : </label>
            @php
            $date = $content->end_date;
            if($date== ""){
                $date = "";
            }else{
                $date = \AppHelper::instance()->Bt_date($date);
            }
            @endphp
            <input type="text" class="form-control" id="" name="" value="{{ $date }}" disabled>
        </div>
    </div>
    @endif

    @if(in_array("start_time", Session::get('field_edit')))
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">เวลาที่จัดกิจกรรม : </label>
            @php
            $time = $content->start_time;
            if($time== ""){
                $time = "";
            }else{
                $time = date('H:i:s',strtotime($time));
            }
            @endphp
            <input type="text" class="form-control" name="" id="" value="{{ $time }}" disabled>
        </div>
    </div>
    @endif

    @if(in_array("end_time", Session::get('field_edit')))
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ถึงเวลา : </label>
            @php
            $time = $content->end_time;
            if($time== ""){
                $time = "";
            }else{
                $time = date('H:i:s',strtotime($time));
            }
            @endphp
            <input type="text" class="form-control" name="" id="" value="{{ $time }}" disabled>
        </div>
    </div>
    @endif

    @if(in_array("province_id", Session::get('field_edit')))
    <div class="col-md-4 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="province_id" class="control-label">จังหวัด : </label>
            <input type="text" class="form-control" name="" id="" value="{{ $content->province_name }}" disabled>
        </div>
    </div>
    @endif

    @if(in_array("district_id", Session::get('field_edit')))
    <div class="col-md-4 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">อำเภอ : </label>
            <input type="text" class="form-control" name="" id="" value="{{ $content->district_name }}" disabled>
        </div>
    </div>
    @endif

    @if(in_array("sub_district_id", Session::get('field_edit')))
    <div class="col-md-4 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ตำบล : </label>
            <input type="text" class="form-control" name="" id="" value="{{ $content->sub_district_name }}" disabled>
        </div>
    </div>
    @endif

    @if(in_array("price", Session::get('field_edit')))
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ค่าเข้าชม : </label>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>กฏเกิน</th>
                    <th>ราคา</th>
                </tr>
            </thead>
            <tbody>
            @foreach($content->admission_fees as $k => $v)
                <tr>
                    <td>{{ $v->admission_fee_type_name }}</td>
                    <td>{{ $v->admission_charge }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('shared.modal-price-pay')
    @endif

    @if(in_array("date_work", Session::get('field_edit')))
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">เวลาทำการ : </label>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>วันทำการ</th>
                    <th>เวลา</th>
                </tr>
            </thead>
            <tbody>
            @foreach($content->working_times as $k => $v)
                @php
                    $working_start_time = $v->working_start_time;
                    if($working_start_time== ""){
                        $working_start_time = "";
                    }else{
                        $working_start_time = date('H:i:s',strtotime($working_start_time));
                    }

                    $working_end_time = $v->working_end_time;
                    if($working_end_time == ""){
                        $working_end_time = "";
                    }else{
                        $working_end_time = date('H:i:s',strtotime($working_end_time));
                    }
                @endphp
                <tr>
                    <td>{{ $v->working_start_date }} - {{ $v->working_end_date }}</td>
                    <td>{{ $working_start_time }} - {{ $working_end_time }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    @include('shared.modal-date-work')
    @endif

    @if(in_array("topic_details", Session::get('field_edit')))
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">รายละเอียด : </label>
            <textarea class="form-control" style="resize: none;" rows="3" id="" name="" disabled>{{ $content->topic_details }}</textarea>
        </div>
    </div>
    @endif

    @if(in_array("location", Session::get('field_edit')))
    <div class="col-md-4 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">สถานที่ : </label>
            <input type="text" class="form-control" name="" id="" value="{{ $content->topic_location }}" readonly>
        </div>
    </div>

    <div class="col-md-4 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ละติจูด : </label>
            <input type="text" class="form-control" name="" id="" value="{{ $content->topic_latitude }}" readonly>
        </div>
    </div>

    <div class="col-md-4 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ลองติจูด : </label>
            <input type="text" class="form-control" name="" id="" value="{{ $content->topic_longitude }}" readonly>
        </div>
    </div>
    @endif

    @if(in_array("reference", Session::get('field_edit')))
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">แหล่งข้อมูล : </label>
            <textarea class="form-control" style="resize: none;" rows="3" id="" name="" disabled>{{ $content->reference }}</textarea>
        </div>
    </div>
    @endif

    @if(in_array("topic_remark", Session::get('field_edit')))
    <div class="col-md-12 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">อื่นๆ : </label>
            <textarea class="form-control" style="resize: none;" rows="3" id="" name="" disabled>{{ $content->topic_remark }}</textarea>
        </div>
    </div>
    @endif

    <div class="col-md-12 col-xs-12 col-sm-12">
        <hr />
        <h3 class="text-center">รูปภาพ</h3>
    </div>

    @foreach($content->files as $img)
        <div class="col-md-4 col-xs-6 col-sm-6">
            <div class="parent">
                <img src="{{ $img->file_path }}" class="img-responsive">
            </div>
        </div>
    @endforeach

    <div class="col-md-12 col-xs-12 col-sm-12">
        <hr />
        <h3 class="text-center">ข้อมูลผู้แจ้ง</h3>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">ชื่อ-นามสกุล : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->user_fullname}}" readonly>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">อีเมล : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->user_email}}" readonly>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">หมายเลขโทรศัพท์ : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->user_phone}}" readonly>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="" class="control-label">หมายเลขบัตรประจำตัวประชาชน : </label>
            <input type="text" class="form-control" name="" id="" value="{{$content->user_identification}}" readonly>
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
                            <button type="button" class="btn btn-warning center-block edit-reply" data-class="complaint" data-id="{{$reply->reply_id}}">แก้ไข</button>
                            <label class="text-center">ตอบกลับโดย : {{$reply->reply_by_name}}</label>
                        </div>
                        <div class="col-md-10">
                            <div id="reply_{{$reply->reply_id}}" style="display: block;word-wrap: break-word;">
                                {{$reply->reply_details}}
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
            <label for="reply_details" class="control-label">ตอบกลับ : </label>
            <textarea class="form-control" style="resize : vertical;" rows="3" id="reply_details" name="reply_details" required></textarea>
        </div>
    </div>


    <div class="col-md-12 col-xs-12 col-sm-12">
        <input type="hidden" value="{{ $content->device_token }}" name="device_token">
        <input type="hidden" value="{{ $content->get_news_update }}" name="get_news_update">
        <button type="submit" class="btn btn-success">ตอบกลับ</button>
        <?=link_to('admin/reply-recommend', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null);?>
    </div>
</div>

{!! Form::close() !!}

<!-- Modal -->
<div class="modal fade" id="nofti-reply" role="dialog">
    <div class="modal-dialog">
    {!! Form::open(['url' => '/admin/reply','class' => 'form-auth-small', 'method' => 'put']) !!}
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
                        <input type="hidden" class="form-control" name="reply_id" id="reply_id" value="">
                        <input type="hidden" value="{{ $content->device_token }}" name="device_token">
                        <textarea class="form-control" style="resize : vertical;" rows="3" id="reply_details" name="reply_details" required></textarea>
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