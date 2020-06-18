@extends('master.layout')

@section('title', $title )

@section('header', $header )

@section('content')

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
{!! Form::open(['url' => 'km/hilight/'.$id,'class' => 'form-auth-small', 'method' => 'PUT','files' => true]) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="activity_name" class="control-label">หัวข้อ : </label>
                <input type="text" class="form-control" id="activity_name" name="activity_name" value="{{ $data->activity_name }}" placeholder="หัวข้อ" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="link_ref" class="control-label">URL อ้างอิง : </label>
                <input type="url" class="form-control" id="link_ref" name="link_ref" value="{{ $data->link_ref }}" placeholder="เช่น http://www.sac.or.th/databases/rituals/detail.php?id=86" required="255">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="start_date" class="control-label">วันที่เริ่ม และสิ้นสุด : </label>
                @php
                $start = date("m/d/Y",strtotime($data->start_date));
                $end = date("m/d/Y",strtotime($data->end_date));
                @endphp
                <input type="text" class="form-control date-range" id="" name="datetime" value="{{ $start }} - {{ $end }}" readonly placeholder="">
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="start_time" class="control-label">เวลาเริ่ม : </label>
                <input type="text" class="form-control" id="start_time" name="start_time" value="{{ $data->start_time }}" maxlength="5" placeholder="เช่น 08:00">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="end_time" class="control-label">เวลาสิ้นสุด : </label>
                <input type="text" class="form-control" id="end_time" name="end_time" value="{{ $data->end_time }}" maxlength="5" placeholder="เช่น 18:00">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="activity_location" class="control-label">สถานที่่ : </label>
                <input type="text" class="form-control" id="activity_location" name="activity_location" value="{{ $data->activity_location }}" placeholder="สถานที่่เช่น กรุงเทพ">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="activity_image" class="control-label">รูปภาพประกอบ : </label>
                <input type="file" class="form-control" name="activity_image" id="activity_image" accept="image/*">
                <br >
                <img src="{{ $data->activity_image }}" class="img-responsive">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="activity_details" class="control-label">รายละเอียด : </label>
                <textarea class="form-control" name="activity_details" id="activity_details" style="resize: vertical;" rows="5" required>{{ $data->activity_details }}</textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="link_video" class="control-label">วีดิโอประกอบ : </label>
                <input type="url" class="form-control" name="link_video" id="link_video" value="{{ $data->link_video }}" placeholder="เช่น https://www.youtube.com/watch?v=abcdefg">
            </div>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">บันทึก</button>
            <?= link_to(url("/") . '/km/hilight', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
{!! Form::close() !!}

@endsection
