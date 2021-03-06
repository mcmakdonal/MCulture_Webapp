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
    <div style="margin-bottom: 10px;">
        <?= link_to(url("/") . '/admin/administrator/create', $title = 'เพิ่ม', ['class' => 'btn btn-primary'], $secure = null); ?>
    </div>
    <table class="table table-striped table-bordered datatables">
    <thead>
        <tr>
            <td style="width : 8%;" >ลำดับ</td>
            <td>ชื่อ นามสกุล</td>
            <td>ชื่อผู้ใช้งานระบบ</td>
            <td>บทบาทการทำงาน</td>
            <td class="text-center" style="width: 5%;">แก้ไข</td>
            <td class="text-center" style="width: 5%;">ลบ</td>
        </tr>
    </thead>
    <tbody>
    @foreach($content as $key => $value)
        <tr>
            <td>{{ $key + 1  }}</td>
            <td>{{ $value->fullname }}</td>
            <td>{{ $value->username }}</td>
            @if($value->role == 1)
                <td>ผู้ดูแลระบบสูงสุด</td>
            @elseif($value->role == 2)
                <td>ผู้ดูแลระบบ เฉพาะการตอบกลับ</td>
            @else
                <td>ผู้ดูแลระบบ เฉพาะการออกรายงาน</td>
            @endif
            <td>
                <a class="btn btn-small btn-info" href="{{ url('/admin/administrator/' . $value->user_id . '/edit') }}">แก้ไข</a>
            </td>
            <td>
                <a class="btn btn-small btn-danger" onclick="destroy(this,'/admin/administrator','{{ $value->user_id }}')" >ลบ</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<!-- สำหรับทำ pagi -->
{{-- $content->links() --}}
@endsection