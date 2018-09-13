@extends('master.web-app')

@section('title', $title )

@section('content')
<div class="container">
    <section id="history">
        <div class="row">
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
                <h3 class="text-center">การตอบกลับ</h3>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <ul class="list-unstyled todo-list" style="color: white;">
                    <li>
                        @foreach($content->reply as $reply)
                            <div class="row">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <label class="text-center">ตอบกลับโดย : {{$reply->ifreply_by_name}}</label>
                                </div>
                                <div class="col-md-8 col-sm-8 col-xs-8">
                                    <div id="reply_{{$reply->reply_id}}" style="display: block;word-wrap: break-word;">
                                        {{$reply->ifdetail_reply}}
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
