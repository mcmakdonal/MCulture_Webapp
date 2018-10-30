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
        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="CMTYPE_ID" class="control-label">ประเภท : </label>
                <select class="form-control use-select2" id="CMTYPE_ID" name="CMTYPE_ID">
                    <option value="">ทั้งหมด</option>
                    @foreach ($select as $value)
                        <option value="{{$value->cmtype_id}}" {{ ($select_type == $value->cmtype_id)? 'selected' : '' }} >{{$value->cmtype_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-2 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="" class="control-label">กำหนดช่วงเวลา : </label>
                <select class="form-control use-select2" id="DATE_ONF" onchange="init_date_onf();">
                    <option value="OFF" {{ ($datetime == "")? 'selected' : '' }} >ปิด</option>
                    <option value="ON"  {{ ($datetime != "")? 'selected' : '' }} >เปิด</option>
                </select>
            </div>
        </div>

        <div class="col-md-4 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="DATETIME" class="control-label">ช่วงเวลา : </label>
                <input type="text" class="form-control datetimerange" id="DATETIME" name="DATETIME" value="{{ $datetime }}" placeholder="ช่วงเวลา" required>
            </div>
        </div>

        <div class="col-md-12 col-xs-12 col-sm-12 text-center">
            <button type="submit" class="btn btn-success">ออกรายงาน</button>
            <?=link_to(url()->current(), $title = 'ล้างค่า', ['class' => 'btn btn-warning'], $secure = null);?>
        </div>
    </div>
    {!! Form::close() !!}

    <table class="table table-striped table-bordered report_datatables">
    <thead>
        <tr>
            <td style="width : 8%;" >ลำดับ</td>
            <td>ประเภท</td>
            <td>หัวข้อ</td>
            <td style="display: none">ความคิดเห็น/รายละเอียด</td>
            <td>ชื่อบุคลากร</td>
            <td style="display: none">ชื่อ นามสกุล</td>
            <td style="display: none">อีเมล์</td>
            <td style="display: none">เบอร์โทร</td>
        </tr>
    </thead>
    <tbody>
        @foreach($content as $key => $value)
            <tr>
                <td>{{ $key + 1  }}</td>
                <td>{{ $value->cmtype_name }}</td>
                <td>{{ $value->cmdata_name }}</td>
                <td style="display: none">{{ $value->cmdata_details }}</td>
                <td>{{ $value->cmdata_personname }}</td>
                <td style="display: none">{{ $value->user_fullname }}</td>
                <td style="display: none">{{ $value->user_email }}</td>
                <td style="display: none">{{ $value->user_phonenumber }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<!-- สำหรับทำ pagi -->
{{-- $content->links() --}}
@endsection
