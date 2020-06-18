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
{!! Form::open(['url' => url() . 'km/folkart','class' => 'form-auth-small', 'method' => 'POST','files' => true]) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="folkart_name" class="control-label">หัวข้อ : </label>
                <input type="text" class="form-control" id="folkart_name" name="folkart_name" value="" placeholder="หัวข้อ" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="about" class="control-label">เกี่ยวกับ : </label>
                <input type="text" class="form-control" id="about" name="about" value="" placeholder="เกี่ยวกับ">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="content_url" class="control-label">URL อ้างอิง : </label>
                <input type="url" class="form-control" id="content_url" name="content_url" value="" placeholder="เช่น http://www.sac.or.th/databases/rituals/detail.php?id=86" required="255">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="folkart_img" class="control-label">รูปภาพประกอบ : </label>
                <input type="file" class="form-control" name="folkart_img" id="folkart_img" accept="image/*" required>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="history" class="control-label">รายละเอียด : </label>
                <textarea class="form-control" rows="5" style="resize: vertical;" name="history" id="history" required></textarea>
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
            <?= link_to(url("/") . '/km/folkart', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
{!! Form::close() !!}

@endsection
