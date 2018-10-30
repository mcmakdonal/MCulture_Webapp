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
{!! Form::open(['url' => url()->current(),'class' => 'form-auth-small', 'method' => 'put']) !!}
@csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_FULLNAME" class="control-label">ชื่อ นามสกุล : </label>
                <input type="text" class="form-control" id="ADMIN_FULLNAME" name="ADMIN_FULLNAME" value="{{ $content->fullname }}" placeholder="ชื่อ นามสกุล" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_USERNAME" class="control-label">ชื่อผู้ใช้งานระบบ : </label>
                <input type="text" class="form-control" id="ADMIN_USERNAME" name="ADMIN_USERNAME" value="{{ $content->username }}" placeholder="ชื่อผู้ใช้งานระบบ" readonly>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_PASSWORD" class="control-label">รหัสผ่าน: </label>
                <input type="password" class="form-control" id="ADMIN_PASSWORD" name="ADMIN_PASSWORD" value="" placeholder="รหัสผ่าน">
                <span class="text-muted">ปล่อยว่างไว้ถ้าหากไม่ต้องการเปลี่ยนรหัสผ่าน</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="C_ADMIN_PASSWORD" class="control-label">ยืนยัน รหัสผ่าน : </label>
                <input type="password" class="form-control" id="C_ADMIN_PASSWORD" name="C_ADMIN_PASSWORD" value="" placeholder="ยืนยัน รหัสผ่าน">
                <span class="text-muted">ปล่อยว่างไว้ถ้าหากไม่ต้องการเปลี่ยนรหัสผ่าน</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="role" class="control-label">บทบาทการทำงาน : </label>
                <select class="form-control use-select2" disabled>
                    <option value="">กรุณาเลือก</option>
                    <option value="1" {{ ($content->role == 1)? "selected" : "" }} >ผู้ดูแลระบบสูงสุด</option>
                    <option value="2" {{ ($content->role == 2)? "selected" : "" }} >ผู้ดูแลระบบ เฉพาะการตอบกลับ</option>
                    <option value="3" {{ ($content->role == 3)? "selected" : "" }} >ผู้ดูแลระบบ เฉพาะการออกรายงาน</option>
                </select>
            </div>
        </div>

        <div class="col-md-12">
            <input type="hidden" value="{{ $content->password }}" name="ADMIN_PASSWORD_OLD" id="ADMIN_PASSWORD_OLD">
            <button type="submit" class="btn btn-success">บันทึก</button>
        </div>
    </div>
{!! Form::close() !!}

@endsection
