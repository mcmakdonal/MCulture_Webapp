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
{!! Form::open(['url' => 'km/tradition/'.$id,'class' => 'form-auth-small', 'method' => 'put','files' => true]) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="article_name" class="control-label">หัวข้อ : </label>
                <input type="text" class="form-control" id="article_name" name="article_name" value="{{ $data->article_name }}" placeholder="หัวข้อ" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="about" class="control-label">เกี่ยวกับ : </label>
                <input type="text" class="form-control" id="about" name="about" value="{{ $data->about }}" placeholder="เกี่ยวกับ" required="255" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="event_date" class="control-label">ช่วงเดือน : </label>
                <input type="text" class="form-control" id="event_date" name="event_date" value="{{ $data->event_date }}" placeholder="เช่น เริ่ม วันที่ 3 เดือน มกราคม ถึง วันที่ 4" required="255" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="location" class="control-label">สถานที่ : </label>
                <input type="text" class="form-control" id="location" name="location" value="{{ $data->location }}" placeholder="เช่น บ้านวังโน - อำเภอ วังยาง (นาแก)" required="255" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="content_url" class="control-label">URL อ้างอิง : </label>
                <input type="url" class="form-control" id="content_url" name="content_url" value="{{ $data->content_url }}" placeholder="เช่น http://www.sac.or.th/databases/rituals/detail.php?id=86" required="255">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="article_img" class="control-label">รูปภาพประกอบ : </label>
                <input type="file" class="form-control" name="article_img" id="article_img" accept="image/*">
                <br >
                <img src="{{ $data->article_img }}" class="img-responsive">
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label for="history" class="control-label">รายละเอียด : </label>
                <textarea class="form-control" rows="5" style="resize: vertical;" name="history" id="history" required>{{ $data->history }}</textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="link_video" class="control-label">วีดิโอประกอบ : </label>
                <input type="url" class="form-control" name="link_video" id="link_video" value="{{ $data->link_video }}"  placeholder="เช่น https://www.youtube.com/watch?v=abcdefg">
            </div>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">บันทึก</button>
            <?=link_to('/km/tradition', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null);?>
        </div>
    </div>
{!! Form::close() !!}

@endsection
