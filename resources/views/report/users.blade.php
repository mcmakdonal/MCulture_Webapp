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

    {!! Form::open(['url' => url()->current(),'class' => 'form-auth-small', 'method' => 'post']) !!}
    <div class="row">

        <div class="col-md-4 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="" class="control-label">กำหนดช่วงเวลา : </label>
                <select class="form-control use-select2" id="DATE_ONF" onchange="init_date_onf();">
                    <option value="OFF" {{ ($datetime == "")? 'selected' : '' }} >OFF</option>
                    <option value="ON"  {{ ($datetime != "")? 'selected' : '' }} >ON</option>
                </select>
            </div>
        </div>

        <div class="col-md-4 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="datetime" class="control-label">ช่วงเวลา : </label>
                <input type="text" class="form-control datetimerange" id="datetime" name="datetime" value="{{ $datetime }}" placeholder="ช่วงเวลา" required>
            </div>
        </div>

        <div class="col-md-4"></div>

        <div class="col-md-12 col-xs-12 col-sm-12 text-center">
            <button type="submit" class="btn btn-success">ค้นหา</button>
            <?=link_to(url()->current(), $title = 'Reset', ['class' => 'btn btn-warning'], $secure = null);?>
        </div>
    </div>
    {!! Form::close() !!}

    <table class="table table-striped table-bordered report_datatables">
    <thead>
        <tr>
            <td style="width : 8%;" >No.</td>
            <td>ชื่อผู้ใช้</td>
            <td>เบอร์โทรศัพท์</td>
            <td>อีเมล์</td>
            <td>หมายเลขบัตรประชาชน</td>
        </tr>
    </thead>
    <tbody>
    @foreach($content as $key => $value)
        <tr>
            <td>{{ $key + 1  }}</td>
            <td>{{ $value->user_fullname }}</td>
            <td>{{ isset($value->user_phone)? $value->user_phone : '' }}</td>
            <td>{{ $value->user_email }}</td>
            <td>{{ isset($value->user_identification)? $value->user_identification : '' }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
