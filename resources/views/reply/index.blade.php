@extends('master.layout') 
@section('title', $title ) 
@section('header', $header ) 
@section('content') @if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif {!! Form::open(['url' => url()->current(),'class' => 'form-auth-small', 'method' => 'GET']) !!}
<div class="row">
    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="id" class="control-label">ประเภทย่อย : </label>
            <select class="form-control use-select2" id="id" name="id">
                    <option value="">ทั้งหมด</option>
                    @foreach($sub_type as $k => $v)
                        <option value="{{ $v->topic_sub_type_id }}" {{ ($id == $v->topic_sub_type_id)? 'selected' : '' }} >{{ $v->topic_sub_type_name }}</option>
                    @endforeach
                </select>
        </div>
    </div>

    <div class="col-md-6 col-xs-12 col-sm-12">
        <div class="form-group">
            <label for="reply" class="control-label">สถานะการตอบกลับ : </label>
            <select class="form-control use-select2" id="reply" name="reply">
                    <option value="">ทั้งหมด</option>
                    <option value="A" {{ ($reply == "A")? 'selected' : '' }} >ตอบกลับ</option>
                    <option value="N" {{ ($reply == "N")? 'selected' : '' }} >ยังไม่ตอบกลับ</option>
                </select>
        </div>
    </div>

    <div class="col-md-12 col-xs-12 col-sm-12 text-center">
        <button type="submit" class="btn btn-success">ค้นหา</button>
        <?=link_to(url()->current(), $title = 'ล้างค่า', ['class' => 'btn btn-warning'], $secure = null);?>
    </div>
</div>
{!! Form::close() !!}

<table class="table table-striped table-bordered datatables">
    <thead>
        <tr>
            <td style="width : 10%;">ลำดับ</td>
            <td>ประเภท</td>
            <td>หัวข้อ</td>
            <td>แจ้งโดย</td>
            <td style="width : 5%;" class="text-center">สถานะ</td>
            <td style="width : 5%;" class="text-center">ตอบกลับ</td>
            <td style="width : 5%;" class="text-center">ตอบกลับ</td>
        </tr>
    </thead>
    <tbody>
        @foreach($main_data as $key => $value)
        <tr>
            <td>{{ $key + 1 }}</td>
            <td>{{ $value->topic_sub_type_name }}</td>
            <td>{{ $value->topic_title }}</td>
            <td>{{ $value->user_fullname }}</td>
            <td class="text-center">
                @if($value->reply_status == 'Y')
                <span class="label label-success">ตอบกลับแล้ว</span> @else
                <span class="label label-danger">ยังไม่ตอบกลับ</span> @endif
            </td>
            <td class="text-center">
                <?=link_to('/admin/reply/' . $value->topic_id , $title = 'ตอบกลับ', ['class' => 'btn btn-primary'], $secure = null);?>
            </td>
            <td class="text-center">
                <button type="button" class="btn btn-danger" onclick="destroy(this,'/admin/remove-topic','{{ $value->topic_id }}')">ลบ</button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection