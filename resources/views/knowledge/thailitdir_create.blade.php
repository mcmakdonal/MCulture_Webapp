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
{!! Form::open(['url' => 'km/thailitdir','class' => 'form-auth-small', 'method' => 'POST','files' => true]) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="title_main" class="control-label">หัวข้อ : </label>
                <input type="text" class="form-control" id="title_main" name="title_main" value="" placeholder="หัวข้อ" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="composition" class="control-label">ประเภท : </label>
                <input type="text" class="form-control" id="composition" name="composition" value="" placeholder="ประเภท" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="author" class="control-label">ผู้เขียน : </label>
                <input type="text" class="form-control" id="author" name="author" value="" placeholder="ผู้เขียน" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="composer" class="control-label">ผู้เรียบเรียง : </label>
                <input type="text" class="form-control" id="composer" name="composer" value="" placeholder="ผู้เรียบเรียง" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="content_url" class="control-label">URL อ้างอิง : </label>
                <input type="url" class="form-control" id="content_url" name="content_url" value="" placeholder="เช่น http://www.sac.or.th/databases/rituals/detail.php?id=86" required="255">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="story" class="control-label">รายละเอียด : </label>
                <textarea class="form-control" name="story" id="story" style="resize: vertical;" rows="5" required></textarea>
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
            <?= link_to('/km/thailitdir', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
{!! Form::close() !!}

@endsection
