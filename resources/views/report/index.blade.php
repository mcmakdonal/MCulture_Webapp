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

    {!! Form::open(['url' => '/admin/report-generate','class' => 'form-auth-small', 'method' => 'POST']) !!}
    <div class="row">

        <div class="col-md-4 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="" class="control-label">กำหนดช่วงเวลา : </label>
                <select class="form-control use-select2" id="DATE_ONF" onchange="init_date_onf();">
                    <option value="OFF" selected>OFF</option>
                    <option value="ON">ON</option>
                </select>
            </div>
        </div>

        <div class="col-md-4 col-xs-12 col-sm-12">
            <div class="form-group">
                <label for="datetime" class="control-label">ช่วงเวลา : </label>
                <input type="text" class="form-control datetimerange" id="datetime" name="datetime" value="" placeholder="ช่วงเวลา" required>
            </div>
        </div>

        <div class="col-md-4"></div>

        <div class="col-md-12 col-xs-12 col-sm-12 text-center">
            <input type="hidden" name="read_status" value="{{ $read_status }}">
            <input type="hidden" name="reply_status" value="{{ $reply_status }}">
            <input type="hidden" name="report_type" value="{{ $report_type }}">
            <button type="submit" class="btn btn-success">ค้นหา</button>
            <?=link_to(url()->current(), $title = 'Reset', ['class' => 'btn btn-warning'], $secure = null);?>
        </div>
    </div>
    {!! Form::close() !!}
@endsection
