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

    {!! Form::open(['url' => url("/") . url()->current(),'class' => 'form-auth-small', 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="CPTYPE_ID" class="control-label">ประเภท : </label>
                <select class="form-control use-select2" id="CPTYPE_ID" name="CPTYPE_ID">
                    <option value="">ทั้งหมด</option>
                    @foreach ($select as $value)
                    <option value="{{$value->cptype_id}}" {{ ($select_type == $value->cptype_id)? 'selected' : '' }} >{{$value->cptype_name}}</option>
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
                @if ($select_type == 1)
                    <td style="display: none">ชื่อร้านค้า</td>
                    <td style="display: none">จังหวัด</td>
                    <td style="display: none">อำเภอ</td>
                    <td style="display: none">ตำบล</td>
                    <td style="display: none">รายละเอียดสถานที่่</td>
                    <td style="display: none">ละติจูด</td>
                    <td style="display: none">ลองจิจูด</td>
                @elseif ($select_type == 2)
                    <td style="display: none">ประเภทสื่อ</td>
                @elseif ($select_type == 3)
                @elseif ($select_type == 4)
                    <td style="display: none">รายละเอียดสถานที่่</td>
                    <td style="display: none">ละติจูด</td>
                    <td style="display: none">ลองจิจูด</td>
                @else
                    <td style="display: none">ชื่อร้านค้า</td>
                    <td style="display: none">จังหวัด</td>
                    <td style="display: none">อำเภอ</td>
                    <td style="display: none">ตำบล</td>
                    <td style="display: none">ประเภทสื่อ</td>
                    <td style="display: none">รายละเอียดสถานที่่</td>
                    <td style="display: none">ละติจูด</td>
                    <td style="display: none">ลองจิจูด</td>
                @endif
                    <td style="display: none">ชื่อ นามสกุล</td>
                    <td style="display: none">อีเมล</td>
                    <td style="display: none">เบอร์โทร</td>
                    <td style="display: none">รูปภาพ</td>
            </tr>
        </thead>
        <tbody>
        @foreach($content as $key => $value)
            <tr>
                <td>{{ $key + 1  }}</td>
                <td>{{ $value->cptype_name }}</td>
                <td>{{ $value->cpdata_name }}</td>
                <td style="display: none">{{ $value->cpdata_details }}</td>
                @if ($select_type == 1)
                    <td style="display: none">{{ $value->cpdata_storename }}</td>
                    <td style="display: none">{{ $value->province_name }}</td>
                    <td style="display: none">{{ $value->district_name }}</td>
                    <td style="display: none">{{ $value->subdistrict_name }}</td>
                    <td style="display: none">{{ $value->cpdata_location }}</td>
                    <td style="display: none">{{ $value->cpdata_latitude }}</td>
                    <td style="display: none">{{ $value->cpdata_longitude }}</td>
                @elseif ($select_type == 2)
                    <td style="display: none">-</td>
                @elseif ($select_type == 3)
                @elseif ($select_type == 4)
                    <td style="display: none">{{ $value->cpdata_location }}</td>
                    <td style="display: none">{{ $value->cpdata_latitude }}</td>
                    <td style="display: none">{{ $value->cpdata_longitude }}</td>
                @else
                    <td style="display: none">{{ $value->cpdata_storename }}</td>
                    <td style="display: none">{{ $value->province_name }}</td>
                    <td style="display: none">{{ $value->district_name }}</td>
                    <td style="display: none">{{ $value->subdistrict_name }}</td>
                    <td style="display: none">-</td>
                    <td style="display: none">{{ $value->cpdata_location }}</td>
                    <td style="display: none">{{ $value->cpdata_latitude }}</td>
                    <td style="display: none">{{ $value->cpdata_longitude }}</td>
                @endif
                    <td style="display: none">{{ $value->user_fullname }}</td>
                    <td style="display: none">{{ $value->user_email }}</td>
                    <td style="display: none">{{ $value->user_phonenumber }}</td>
                    @php
                        $image = [];
                    @endphp
                    @foreach($value->images as $k => $v)
                        @php
                            $image[$k] = $v->image_path;
                        @endphp
                    @endforeach
                    <td style="display: none">@json($image, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)</td>
            </tr>
        @endforeach
        </tbody>
    </table>

<!-- สำหรับทำ pagi -->
{{-- $content->links() --}}
@endsection
