@extends('master.web-app')

@section('title', $title )

@section('content')

<section>
    <img src="{{ asset('frontend-assets/assets/imgs/head_info.jpg' )}}" class="img-responsive">
</section>

<section id="complaintform">

    <div class="container">

        {!! Form::open(['url' => '/form/inform','class' => 'form-auth-small', 'method' => 'post','id' => 'form-form','files'=> true] ) !!}

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

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="IFTYPE_ID" class="control-label">ประเภท <span class="must-input">*</span> : </label>
                    <select class="form-control use-select2" id="IFTYPE_ID" name="IFTYPE_ID" onchange="change_inform();">
                        @foreach ($select as $value)
                        <option value="{{$value->iftype_id}}">{{$value->iftype_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="IFDATA_NAME" class="control-label">หัวข้อ <span class="must-input">*</span> : </label>
                    <input type="text" class="form-control" id="IFDATA_NAME" name="IFDATA_NAME" value="" placeholder="หัวข้อ">
                </div>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="IFDATA_DETAILS" class="control-label">รายละเอียด <span class="must-input">*</span> : </label>
                    <textarea class="form-control" style="resize: none;" rows="3" id="IFDATA_DETAILS" name="IFDATA_DETAILS"></textarea>
                </div>
            </div>

            <!-- <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="IMAGE_NAME" class="control-label">รูปภาพ : </label>
                    <input type="file" class="form-control" name="IMAGE_NAME[]" id="IMAGE_NAME" accept="image/x-png,image/jpeg" multiple>
                </div>
            </div> -->

            <div class="col-md-6 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="IMAGE_NAME" class="control-label">รูปภาพ : </label>
                    <div class="input-group">
                        <input type="text" class="form-control" readonly>
                        <div class="input-group-btn">
                        <span class="fileUpload btn btn-info">
                            <span class="upl" id="upload">เลือกได้หลายไฟล์</span>
                            <input type="file" class="upload up" name="IMAGE_NAME[]" id="IMAGE_NAME" accept="image/x-png,image/jpeg" multiple readonly>
                            </span>
                        </div>
                    </div>
                </div>
            </div>


            <div id="form-replace">

            </div>

            <!-- Modal -->
            <div class="modal fade" id="register" role="dialog">
                <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">กรอกข้อมูล</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label for="USER_FULLNAME" class="control-label">ชื่อ นามสกุลผู้ใช้งาน <span class="must-input">*</span> : </label>
                                    <input type="text" class="form-control" id="USER_FULLNAME" name="USER_FULLNAME" value="" placeholder="ชื่อ นามสกุลผู้ใช้งาน">
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label for="USER_EMAIL" class="control-label">อีเมลผู้ใช้งาน <span class="must-input">*</span> : </label>
                                    <input type="email" class="form-control" id="USER_EMAIL" name="USER_EMAIL" value="" placeholder="อีเมลผู้ใช้งาน">
                                </div>
                            </div>

                            <div class="col-md-6 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label for="USER_PHONENUMBER" class="control-label">หมายเลขโทรศัพท์ผู้ใช้งาน <span class="must-input">*</span> : </label>
                                    <input type="text" class="form-control number-on" name="USER_PHONENUMBER" id="USER_PHONENUMBER">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success submit-color">ส่งข้อมูล</button>
                    </div>
                </div>

                </div>
            </div>

            <div class="col-md-6 col-xs-12 col-sm-12">
                <?=link_to('/', $title = 'ยกเลิก', ['class' => 'col-xs-4 btn btn-warning can-color'], $secure = null);?>
                <button type="button" class="btn btn-success col-xs-8 inform-form-check submit-color">ส่งข้อมูล</button>
            </div>
        </div>
        {!! Form::close() !!}

    </div>

</section>

<div class="hidden">

    <div id="form-1">

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="PROVINCE_ID" class="control-label">จังหวัด : </label>
                <select class="form-control" id="PROVINCE_ID" name="PROVINCE_ID" onchange="search_district(this);">
                <select>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="DISTRICT_ID" class="control-label">อำเภอ : </label>
                <select class="form-control" id="DISTRICT_ID" name="DISTRICT_ID" onchange="search_subdistrict(this);">
                <select>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="SUB_DISTRICT_ID" class="control-label">ตำบล : </label>
                <select class="form-control" id="SUB_DISTRICT_ID" name="SUB_DISTRICT_ID">
                <select>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="IFDATA_DATE" class="control-label">วันที่ : </label>
                <input type="text" class="form-control form_date" id="IFDATA_DATE" name="IFDATA_DATE" readonly>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="IFDATA_TIMES" class="control-label">เวลา : </label>
                <input type="text" class="form-control form_time" name="IFDATA_TIMES" id="IFDATA_TIMES" readonly>
            </div>
        </div>

    </div>

    <div id="form-2">

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="PROVINCE_ID" class="control-label">จังหวัด : </label>
                <select class="form-control" id="PROVINCE_ID" name="PROVINCE_ID" onchange="search_district(this);">
                <select>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="DISTRICT_ID" class="control-label">อำเภอ : </label>
                <select class="form-control" id="DISTRICT_ID" name="DISTRICT_ID" onchange="search_subdistrict(this);">
                <select>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="SUB_DISTRICT_ID" class="control-label">ตำบล : </label>
                <select class="form-control" id="SUB_DISTRICT_ID" name="SUB_DISTRICT_ID">
                <select>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="IFDATA_PRICE" class="control-label">ค่าเช้าชม : </label>
                <input type="text" class="form-control number-on" name="IFDATA_PRICE" id="IFDATA_PRICE">
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="IFDATA_OPENTIME" class="control-label">เวลาเปิด : </label>
                <input type="text" class="form-control form_time" name="IFDATA_OPENTIME" id="IFDATA_OPENTIME" readonly>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="IFDATA_CLOSETIME" class="control-label">เวลาปิด : </label>
                <input type="text" class="form-control form_time" name="IFDATA_CLOSETIME" id="IFDATA_CLOSETIME" readonly>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="IFDATA_LOCATION" class="control-label">Location : </label>
                <button type="button" class="btn btn-primary" onclick="map_init();">Google Map</button>
                <input type="text" class="form-control" name="IFDATA_LOCATION" id="IFDATA_LOCATION" readonly>
                <input type="text" class="form-control" name="IFDATA_LATITUDE" id="IFDATA_LATITUDE" readonly>
                <input type="text" class="form-control" name="IFDATA_LONGITUDE" id="IFDATA_LONGITUDE" readonly>
            </div>
        </div>

    </div>

    <div id="form-3">
    </div>

</div>

    @include('shared.modal-map')  

 @endsection

 @section('script')
 <script>
// preload window
$(document).ready(function($) {
  change_inform();
});
</script>
 @endsection
