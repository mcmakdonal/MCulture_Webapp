@extends('master.web-app')

@section('title', $title )

@section('content')

<section id="recommendform">

    <div class="">

        {!! Form::open(['url' => url()->current(),'class' => 'form-auth-small', 'method' => 'post','id' => 'form-form','files'=> true] ) !!}
        <div class="row">

            <div class="col-md-12 col-xs-12 col-sm-12">
                <h3 class="text-center">{{ Session::get('title') }}</h3>
            </div>
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

            @if(in_array("religion_id", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="media_type_id" class="control-label">ประเภทศาสนา <span class="must-input">*</span> : </label>
                    <select class="form-control use-select2" id="religion_id" name="religion_id">
                        @foreach($get_religion as $k => $v)
                            <option value="{{$v->religion_id}}">{{$v->religion_name}}</option>
                        @endforeach
                    <select>
                </div>
            </div>
            @endif

            @if(in_array("organize_id", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="organize_id" class="control-label">หน่วยงาน <span class="must-input">*</span> : </label>
                    <select class="form-control use-select2" id="organize_id" name="organize_id">
                    @foreach($get_organizations as $k => $v)
                        <option value="{{$v->organize_id}}">{{$v->organize_name}}</option>
                    @endforeach
                    <select>
                </div>
            </div>
            @endif

            @if(in_array("commerce_type_id", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="media_type_id" class="control-label">ประเภทสื่อ <span class="must-input">*</span> : </label>
                    <select class="form-control use-select2" id="commerce_type_id" name="commerce_type_id">
                        @foreach($get_commerce as $k => $v)
                            <option value="{{$v->commerce_type_id}}">{{$v->commerce_type_name}}</option>
                        @endforeach
                    <select>
                </div>
            </div>
            @endif

            @if(in_array("topic_title", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">หัวข้อ/เหตุการณ์ <span class="must-input">*</span> : </label>
                    <input type="text" class="form-control" id="topic_title" name="topic_title" value="" placeholder="หัวข้อ/เหตุการณ์">
                </div>
            </div>
            @endif

            @if(in_array("business_name", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="business_name" class="control-label">ชื่อร้าน : </label>
                    <input type="text" class="form-control" id="business_name" name="business_name" value="" placeholder="ชื่อร้าน">
                </div>
            </div>
            @endif

            @if(in_array("start_date", Session::get('field')))
            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">วันที่จัดกิจกรรม : </label>
                    <input type="text" class="form-control form_date" id="start_date" name="start_date" readonly>
                </div>
            </div>
            @endif

            @if(in_array("end_date", Session::get('field')))
            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">ถึงวันที่ : </label>
                    <input type="text" class="form-control end_date" id="end_date" name="end_date" readonly>
                </div>
            </div>
            @endif

            @if(in_array("start_time", Session::get('field')))
            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">เวลาที่จัดกิจกรรม : </label>
                    <input type="text" class="form-control form_time" name="start_time" id="start_time" readonly>
                </div>
            </div>
            @endif

            @if(in_array("end_time", Session::get('field')))
            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">ถึงเวลา : </label>
                    <input type="text" class="form-control form_time" name="end_time" id="end_time" readonly>
                </div>
            </div>
            @endif

            @if(in_array("province_id", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="province_id" class="control-label">จังหวัด : </label>
                    <select class="form-control" id="province_id" name="province_id" onchange="search_district(this);">
                    <select>
                </div>
            </div>
            @endif

            @if(in_array("district_id", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="district_id" class="control-label">อำเภอ : </label>
                    <select class="form-control" id="district_id" name="district_id" onchange="search_subdistrict(this);">
                    <select>
                </div>
            </div>
            @endif

            @if(in_array("sub_district_id", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="sub_district_id" class="control-label">ตำบล : </label>
                    <select class="form-control" id="sub_district_id" name="sub_district_id">
                    <select>
                </div>
            </div>
            @endif

            @if(in_array("price", Session::get('field')))
            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <button type="button" class="btn btn-success btn-block" onclick="price_init();">กำหนดราคา ค่าเข้าชม</button>
                </div>
            </div>
            @include('shared.modal-price-pay')
            @endif

            @if(in_array("date_work", Session::get('field')))
            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <button type="button" class="btn btn-success btn-block" onclick="date_work_init();">กำหนดวัน เวลาทำการ</button>
                </div>
            </div>
            @include('shared.modal-date-work')
            @endif

            @if(in_array("topic_details", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">รายละเอียด <span class="must-input">*</span> : </label>
                    <textarea class="form-control" style="resize: none;" rows="3" id="topic_details" name="topic_details"></textarea>
                </div>
            </div>
            @endif

            @if(in_array("location", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="topic_location" class="control-label">Location : </label>
                    <button type="button" class="btn btn-primary" onclick="map_init();">Google Map</button>
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <input type="text" class="form-control" name="topic_location" id="topic_location" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <input type="text" class="form-control" name="topic_latitude" id="topic_latitude" readonly>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 5px;">
                        <div class="col-md-12 col-xs-12 col-sm-12">
                            <input type="text" class="form-control" name="topic_longitude" id="topic_longitude" readonly>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(in_array("file", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="IMAGE_NAME" class="control-label">รูปภาพ : </label>
                    <div class="input-group">
                        <input type="text" class="form-control file-view" readonly>
                        <div class="input-group-btn">
                        <span class="fileUpload btn btn-info">
                            <span class="upl" id="upload">เลือกได้หลายไฟล์</span>
                            <input type="file" class="upload up limit-file" name="file[]" id="file" accept="image/x-png,image/jpeg" multiple readonly>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if(in_array("reference", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">แหล่งข้อมูล : </label>
                    <textarea class="form-control" style="resize: none;" rows="3" id="reference" name="reference"></textarea>
                </div>
            </div>
            @endif

            @if(in_array("topic_remark", Session::get('field')))
            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">อื่นๆ <span class="must-input">*</span> : </label>
                    <textarea class="form-control" style="resize: none;" rows="3" id="topic_remark" name="topic_remark"></textarea>
                </div>
            </div>
            @endif

            @include('shared.modal-register')

            <div class="col-md-12 col-xs-12 col-sm-12">
                <?=link_to('/recommend', $title = 'ยกเลิก', ['class' => 'col-xs-4 btn btn-warning can-color'], $secure = null);?>
                <button type="button" class="btn btn-success col-xs-8 form-check submit-color">ส่งข้อมูล</button>
            </div>
        </div>
        {!! Form::close() !!}
        @include('shared.modal-map')
        
    </div>

</section>
@endsection
@section('script')
<script>
// preload window
$(document).ready(function() {
    change_bg();
});
</script>
@endsection