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

    {!! Form::open(['url' => url()->current(),'class' => 'form-auth-small', 'method' => 'GET']) !!}
    <div class="row">
        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="IFTYPE_ID" class="control-label">ประเภท : </label>
                <select class="form-control use-select2" id="IFTYPE_ID" name="IFTYPE_ID">
                    <option value="">ทั้งหมด</option>
                    @foreach ($select as $value)
                    <option value="{{$value->iftype_id}}" {{ ($select_type == $value->iftype_id)? 'selected' : '' }} >{{$value->iftype_name}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col-md-6 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="REPLY_STATUS" class="control-label">สถานะการตอบกลับ : </label>
                <select class="form-control use-select2" id="REPLY_STATUS" name="REPLY_STATUS">
                    <option value="">ทั้งหมด</option>
                    <option value="A" {{ ($reply_type == "A")? 'selected' : '' }} >ตอบกลับ</option>
                    <option value="N" {{ ($reply_type == "N")? 'selected' : '' }} >ยังไม่ตอบกลับ</option>
                </select>
            </div>
        </div>       

        <div class="col-md-12 col-xs-12 col-sm-12 text-center">
            <button type="submit" class="btn btn-success">ค้นหา</button>
            <?=link_to(url()->current(), $title = 'Reset', ['class' => 'btn btn-warning'], $secure = null);?>
        </div>
    </div>
    {!! Form::close() !!}    

    <table class="table table-striped table-bordered datatables">
    <thead>
        <tr>
            <td style="width : 8%;">No.</td>
            <td>ประเภท</td>
            <td>หัวข้อ</td>
            <td style="width : 15%;" class="text-center">สถานะการตอบกลับ</td>
            <td style="width : 10%;" class="text-center">ตอบกลับ</td>
        </tr>
    </thead>
    <tbody>
    @foreach($content as $key => $value)
        <tr>
            <td>{{ $key + 1  }}</td>
            <td>{{ $value->iftype_name }}</td>
            <td>{{ $value->ifdata_name }}</td>
            <td class="text-center">
                @if($value->ifdata_reply == 'A')
                    <span class="label label-success">ตอบกลับแล้ว</span>
                @else
                    <span class="label label-danger">ยังไม่ตอบกลับ</span>
                @endif
            </td>
            <td class="text-center">
                <?=link_to('/admin/reply-inform/' . $value->ifdata_id . '/edit', $title = 'Reply', ['class' => 'btn btn-primary'], $secure = null);?>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<!-- สำหรับทำ pagi -->
{{-- $content->links() --}}
@endsection
