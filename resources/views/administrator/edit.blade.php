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
{!! Form::open(['url' => '/admin/administrator/'.$content->user_id,'class' => 'form-auth-small', 'method' => 'put']) !!}
@csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_FULLNAME" class="control-label">Fullname : </label>
                <input type="text" class="form-control" id="ADMIN_FULLNAME" name="ADMIN_FULLNAME" value="{{ $content->fullname }}" placeholder="Fullname" required>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_USERNAME" class="control-label">Username : </label>
                <input type="text" class="form-control" id="ADMIN_USERNAME" name="ADMIN_USERNAME" value="{{ $content->username }}" placeholder="Username" readonly>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="ADMIN_PASSWORD" class="control-label">Password : </label>
                <input type="password" class="form-control" id="ADMIN_PASSWORD" name="ADMIN_PASSWORD" value="" placeholder="Password">
                <span class="text-muted">leave blank if yout don't to change password.</span>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="C_ADMIN_PASSWORD" class="control-label">Confirm Password : </label>
                <input type="password" class="form-control" id="C_ADMIN_PASSWORD" name="C_ADMIN_PASSWORD" value="" placeholder="Confirm Password">
                <span class="text-muted">leave blank if yout don't to change password.</span>
            </div>
        </div>

        <div class="col-md-6">
            <input type="hidden" value="{{ $content->password }}" name="ADMIN_PASSWORD_OLD" id="ADMIN_PASSWORD_OLD">
            <button type="submit" class="btn btn-success">Submit</button>
            <?= link_to('/admin/administrator', $title = 'Cancel', ['class' => 'btn btn-warning'], $secure = null); ?>
        </div>
    </div>
{!! Form::close() !!}

@endsection
