@extends('master.web-app')

@section('title', $title )

@section('content')
<div class="">

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

    <section id="hilight-search">
        <form role="form">
            <div class="form-group float-label-control">
                <label for="">คุณต้องการค้นหาอะไร</label>
                <div class="input-group">
                    <input type="text" class="query_string form-control" placeholder="คุณต้องการค้นหาอะไร" value="">
                    <span class="input-group-btn">
                        <button class="btn btn-modern" type="button" onclick="get_hilight()"><i class="fa fa-search search" aria-hidden="true"></i></button>
                    </span>
                </div>
            </div>
        </form>
    </section>

    <section id="nav-menu" style="margin-top: 30px;">
        <div class="nav-menu">
            <img src="{{ url('frontend-assets/assets/icon/navmenu_kl.png') }}" class="img-responsive">
            <h4 style="color: #783D9B;">ปฏิทินกิจกรรม</h4> <h4 style="color: #CA3E9E;">เดือน{{ \AppHelper::instance()->Month_Year(date('Y-m-d')) }} </h4>
            <hr />
        </div>
    </section>

    <section id="hilight-body">
        <div class="row">

        </div>
    </section>

    <section id="hilight-pagi" style="margin-top: 15px;">
        <div class="row">
            <div class="col-xs-12">
                <span class="totalPages"></span>
            </div>
            <div class="col-xs-12">
                <ul id="pagination" class="pagination-sm"></ul>
            </div>
        </div>
    </section>
</div>

@include('shared.modal-hilight')

@endsection
@section('script')
<script>
// preload window
$(document).ready(function() {
    blank_bg();
    get_hilight();
});
</script>
@endsection
