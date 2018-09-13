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
        <?= link_to('/admin/administrator/create', $title = 'Add', ['class' => 'btn btn-primary'], $secure = null); ?>
    </div>
    <table class="table table-striped table-bordered datatables">
    <thead>
        <tr>
            <td style="width : 8%;" >No.</td>
            <td>FULL NAME</td>
            <td>USERNAME</td>
            <td class="text-center" style="width: 5%;">EDIT</td>
            <td class="text-center" style="width: 5%;">DELETE</td>
        </tr>
    </thead>
    <tbody>
    @foreach($content as $key => $value)
        <tr>
            <td>{{ $key + 1  }}</td>
            <td>{{ $value->fullname }}</td>
            <td>{{ $value->username }}</td>
            <td>
                <a class="btn btn-small btn-info" href="{{ url('/admin/administrator/' . $value->user_id . '/edit') }}">Edit</a>
            </td>
            <td>
                <a class="btn btn-small btn-danger" onclick="destroy(this,'/admin/administrator','{{ $value->user_id }}')" >Delete</a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
<!-- สำหรับทำ pagi -->
{{-- $content->links() --}}
@endsection