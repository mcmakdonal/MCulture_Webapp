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
{!! Form::open(['url' => '/km/rituals','class' => 'form-auth-small', 'method' => 'post','files' => true]) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="content_name" class="control-label">หัวข้อ : </label>
                <input type="text" class="form-control" id="content_name" name="content_name" value="" placeholder="หัวข้อ" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="other_name" class="control-label">ชื่ออื่นๆ : </label>
                <input type="text" class="form-control" id="other_name" name="other_name" value="" placeholder="หัวข้อ" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="type" class="control-label">ประเภท : </label>
                <input type="text" class="form-control tags" id="type" name="type" value="" placeholder="ประเภท">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="keyword" class="control-label">คีย์เวิร์ด : </label>
                <input type="text" class="form-control tags" id="keyword" name="keyword" value="" placeholder="คีย์เวิร์ด">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="rituals_month" class="control-label">ช่วงเดือน : </label>
                <input type="text" class="form-control" id="rituals_month" name="rituals_month" value="" placeholder="เช่น เมษายน" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="rituals_time" class="control-label">ช่วงเวลา : </label>
                <input type="text" class="form-control" id="rituals_time" name="rituals_time" value="" placeholder="เช่น เดือน 4 หรือเดือน 5 (ในอดีตจัดในวันแรม 3 ค่ำ เดือน 4)" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="zone" class="control-label">ภาค จังหวัด : </label>
                <input type="text" class="form-control" id="zone" name="zone" value="" placeholder="เช่น ภาคกลาง สุโขทัย" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="location" class="control-label">สถานที่ : </label>
                <input type="text" class="form-control" id="location" name="location" value="" placeholder="เช่น วัดหาดเสี้ยว ต.หาดเสี้ยว อ.ศรีสัชนาลัย จ.สุโขทัย" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="content_url" class="control-label">URL อ้างอิง : </label>
                <input type="url" class="form-control" id="content_url" name="content_url" value="" placeholder="เช่น http://www.sac.or.th/databases/rituals/detail.php?id=86">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="content_img" class="control-label">รูปภาพประกอบ : </label>
                <input type="file" class="form-control" name="content_img" id="content_img" accept="image/*" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="link_video" class="control-label">วีดิโอประกอบ : </label>
                <input type="url" class="form-control" name="link_video" id="link_video" placeholder="เช่น https://www.youtube.com/watch?v=abcdefg">
            </div>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">บันทึก</button>
            <?= link_to('/km/rituals', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
{!! Form::close() !!}

@endsection
