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
                    <label for="media_type_id" class="control-label">ประเภทสื่อ : </label>
                    <select class="form-control use-select2" id="commerce_type_id" name="commerce_type_id">
                        @foreach($get_commerce as $k => $v)
                            <option value="{{$v->commerce_type_id}}">{{$v->commerce_type_name}}</option>
                        @endforeach
                    <select>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">หัวข้อ/เหตุการณ์ <span class="must-input">*</span> : </label>
                    <input type="text" class="form-control" id="topic_title" name="topic_title" value="" placeholder="หัวข้อ/เหตุการณ์">
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="business_name" class="control-label">ชื่อร้าน : </label>
                    <input type="text" class="form-control" id="business_name" name="business_name" value="" placeholder="ชื่อร้าน">
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
                    <label for="topic_remark" class="control-label">อื่นๆ : </label>
                    <textarea class="form-control" style="resize: none;" rows="3" id="topic_remark" name="topic_remark"></textarea>
                </div>
            </div>
            
            @include('shared.modal-map')  
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
