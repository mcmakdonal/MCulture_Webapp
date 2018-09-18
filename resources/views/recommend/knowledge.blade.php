@extends('master.web-app')

@section('title', $title )

@section('content')

<!-- <section>
    <img src="{{ asset('frontend-assets/assets/imgs/head_complaint.jpg' )}}" class="img-responsive center-block">
</section> -->

<section id="recommendform">

    <div class="container">

        {!! Form::open(['url' => url()->current(),'class' => 'form-auth-small', 'method' => 'post','id' => 'form-form','files'=> true] ) !!}
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
                    <label for="" class="control-label">หัวข้อ/เหตุการณ์ <span class="must-input">*</span> : </label>
                    <input type="text" class="form-control" id="topic_title" name="topic_title" value="" placeholder="หัวข้อ/เหตุการณ์">
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">วันที่ : </label>
                    <input type="text" class="form-control form_date" id="start_date" name="start_date" readonly>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">เวลา : </label>
                    <input type="text" class="form-control form_time" name="start_time" id="start_time" readonly>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="province_id" class="control-label">จังหวัด : </label>
                    <select class="form-control" id="province_id" name="province_id" onchange="search_district(this);">
                    <select>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="district_id" class="control-label">อำเภอ : </label>
                    <select class="form-control" id="district_id" name="district_id" onchange="search_subdistrict(this);">
                    <select>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="sub_district_id" class="control-label">ตำบล : </label>
                    <select class="form-control" id="sub_district_id" name="sub_district_id">
                    <select>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">รายละเอียด <span class="must-input">*</span> : </label>
                    <textarea class="form-control" style="resize: none;" rows="3" id="topic_details" name="topic_details"></textarea>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="IMAGE_NAME" class="control-label">รูปภาพ <span class="must-input">*</span> : </label>
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

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">แหล่งข้อมูล : </label>
                    <textarea class="form-control" style="resize: none;" rows="3" id="reference" name="reference"></textarea>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">อื่นๆ : </label>
                    <textarea class="form-control" style="resize: none;" rows="3" id="topic_remark" name="topic_remark"></textarea>
                </div>
            </div>

            @include('shared.modal-register')

            <div class="col-md-12 col-xs-12 col-sm-12">
                <?=link_to('/recommend', $title = 'ยกเลิก', ['class' => 'col-xs-4 btn btn-warning can-color'], $secure = null);?>
                <button type="button" class="btn btn-success col-xs-8 form-check submit-color">ส่งข้อมูล</button>
            </div>
        </div>
        {!! Form::close() !!}

    </div>

</section>
@endsection
