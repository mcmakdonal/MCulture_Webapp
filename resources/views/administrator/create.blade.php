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
{!! Form::open(['url' => '/admin/administrator','class' => 'form-auth-small', 'method' => 'post']) !!}
@csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_FULLNAME" class="control-label">Fullname : </label>
                <input type="text" class="form-control" id="ADMIN_FULLNAME" name="ADMIN_FULLNAME" value="" placeholder="Fullname" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_USERNAME" class="control-label">Username : </label>
                <input type="text" class="form-control" id="ADMIN_USERNAME" name="ADMIN_USERNAME" value="" placeholder="Username" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_PASSWORD" class="control-label">Password : </label>
                <input type="password" class="form-control" id="ADMIN_PASSWORD" name="ADMIN_PASSWORD" value="" placeholder="Password" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="C_ADMIN_PASSWORD" class="control-label">Confirm Password : </label>
                <input type="password" class="form-control" id="C_ADMIN_PASSWORD" name="C_ADMIN_PASSWORD" value="" placeholder="Confirm Password" required>
            </div>
        </div>

        <div class="col-md-6">
            <button type="submit" class="btn btn-success">Submit</button>
            <?= link_to('/admin/administrator', $title = 'Cancel', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
{!! Form::close() !!}

@endsection
