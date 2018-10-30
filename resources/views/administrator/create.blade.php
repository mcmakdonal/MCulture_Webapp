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
{!! Form::open(['url' => '/admin/administrator','class' => 'form-auth-small', 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_FULLNAME" class="control-label">ชื่อ นามสกุล : </label>
                <input type="text" class="form-control" id="ADMIN_FULLNAME" name="ADMIN_FULLNAME" value="" placeholder="ชื่อ นามสกุล" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_USERNAME" class="control-label">ชื่อผู้ใช้งานระบบ : </label>
                <input type="text" class="form-control" id="ADMIN_USERNAME" name="ADMIN_USERNAME" value="" placeholder="ชื่อผู้ใช้งานระบบ" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_PASSWORD" class="control-label">รหัสผ่าน : </label>
                <input type="password" class="form-control" id="ADMIN_PASSWORD" name="ADMIN_PASSWORD" value="" placeholder="รหัสผ่าน" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="C_ADMIN_PASSWORD" class="control-label">ยืนยัน รหัสผ่าน: </label>
                <input type="password" class="form-control" id="C_ADMIN_PASSWORD" name="C_ADMIN_PASSWORD" value="" placeholder="ยืนยัน รหัสผ่าน" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="role" class="control-label">บทบาทการทำงาน : </label>
                <select class="form-control use-select2" name="role" id="role" required>
                    <option value="">กรุณาเลือก</option>
                    <option value="1">ผู้ดูแลระบบสูงสุด</option>
                    <option value="2">ผู้ดูแลระบบ เฉพาะการตอบกลับ</option>
                    <option value="3">ผู้ดูแลระบบ เฉพาะการออกรายงาน</option>
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <button type="submit" class="btn btn-success">บันทึก</button>
            <?= link_to('/admin/administrator', $title = 'ยกเลิก', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
{!! Form::close() !!}

@endsection
