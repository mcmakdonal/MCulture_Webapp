@extends('master.web-app')

@section('title', $title )

@section('content')
<div class="container">
    <section id="index-logo">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
                <div class="logo-top">
                    <img src="{{ url('frontend-assets/assets/icon/logo.png') }}" class="img-responsive center-block">
                </div>
            </div>
        </div>
    </div>

    <section id="error">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">
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
            </div>
        </div>
    </section>

    <section id="index-contact">
        <div class="row">
            {!! Form::open(['url' => '/recommend','class' => 'form-auth-small', 'method' => 'post','id' => 'form-form'] ) !!}

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">ประเภทของการแนะนำ <span class="must-input">*</span> : </label>
                    <select class="form-control use-select2" id="topic_main_type_id" name="topic_main_type_id" onchange="recommend_init()">
                        @foreach($main_type as $k => $v)
                            <option value="{{ $v->topic_main_type_id }}"> {{ $v->topic_main_type_name }} </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="" class="control-label">ประเภทของการแนะนำย่อย <span class="must-input">*</span> : </label>
                    <select class="form-control" id="topic_sub_type_id" name="topic_sub_type_id">
                    </select>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="">
                    <?=link_to('/', $title = 'ยกเลิก', ['class' => 'col-md-4 btn btn-warning can-color'], $secure = null);?>
                    <button type="submit" class="btn btn-success col-xs-8 submit-color">ดำเนินการต่อ</button>
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>
    
</div>
@endsection
 @section('script')
 <script>
// preload window
$(document).ready(function($) {
    recommend_init();
});
</script>
 @endsection