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
    <div style="margin-bottom: 10px;">
        <?= link_to('/km/folkart/create', $title = 'เพิ่ม', ['class' => 'btn btn-primary'], $secure = null); ?>
    </div>
    <table class="table table-striped table-bordered datatables">
    <thead>
        <tr>
            <td style="width : 8%;" >No.</td>
            <td>หัวข้อ</td>
            <td class="text-center" style="width: 5%;">แก้ไข</td>
            <td class="text-center" style="width: 5%;">ลบ</td>
        </tr>
    </thead>
    <tbody>
    @foreach($data as $k => $v)
        <tr>
            <td style="width : 8%;" >{{ $k + 1 }}</td>
            <td>{{ $v->folkart_name }}</td>
            <td>
                <a class="btn btn-small btn-info" href="{{ url('/km/folkart/' . $v->content_id . '/edit') }}">แก้ไข</a>
            </td>
            <td>
                <a class="btn btn-small btn-danger" onclick="destroy(this,'/km/folkart','{{ $v->content_id }}')" >ลบ</a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection