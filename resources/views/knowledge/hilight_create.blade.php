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
{!! Form::open(['url' => 'km/hilight','class' => 'form-auth-small', 'method' => 'POST','files' => true]) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="activity_name" class="control-label">หัวข้อ : </label>
                <input type="text" class="form-control" id="activity_name" name="activity_name" value="" placeholder="หัวข้อ" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="link_ref" class="control-label">URL อ้างอิง : </label>
                <input type="url" class="form-control" id="link_ref" name="link_ref" value="" placeholder="เช่น http://www.sac.or.th/databases/rituals/detail.php?id=86" required="255">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="datetime" class="control-label">วันที่เริ่ม และสิ้นสุด : </label>
                <input type="text" class="form-control date-range" id="" name="datetime" value="" readonly placeholder="">
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="form-group">
                <label for="start_time" class="control-label">เวลาเริ่ม : </label>
                <input type="text" class="form-control" id="start_time" name="start_time" value="" maxlength="5" placeholder="เช่น 08:00">
            </div>
        </div>

        <div class="col-md-3">
            <div class="form-group">
                <label for="end_time" class="control-label">เวลาสิ้นสุด : </label>
                <input type="text" class="form-control" id="end_time" name="end_time" value="" maxlength="5" placeholder="เช่น 18:00">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="activity_location" class="control-label">สถานที่่ : </label>
                <input type="text" class="form-control" id="activity_location" name="activity_location" value="" placeholder="สถานที่่เช่น กรุงเทพ">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="activity_image" class="control-label">รูปภาพประกอบ : </label>
                <input type="file" class="form-control" name="activity_image" id="activity_image" accept="image/*" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="activity_details" class="control-label">รายละเอียด : </label>
                <textarea class="form-control" name="activity_details" id="activity_details" style="resize: vertical;" rows="5" required></textarea>
            </div>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">บันทึก</button>
            <?= link_to('/km/hilight', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
{!! Form::close() !!}

@endsection
