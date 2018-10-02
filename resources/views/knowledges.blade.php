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

    <section id="knowledge-search">
        <form role="form">
            <div class="form-group float-label-control">
                <label for="">คุณต้องการค้นหาอะไร</label>
                <div class="input-group">
                    <input type="text" class="query_string form-control" placeholder="คุณต้องการค้นหาอะไร" value="">
                    <span class="input-group-btn">
                        <button class="btn btn-modern" type="button" onclick="get_knowledge();"><i class="fa fa-search search" aria-hidden="true"></i></button>
                    </span>
                </div>
            </div>
        </form>
    </section>

    <section id="knowledge-cat" style="margin-top: 30px;">
        <div class="row text-center">
            <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                <img data-id="1" src="{{ url('frontend-assets/assets/icon/kl_01-at.png') }}" class="img-responsive center-block active-img active-know">
                <span>ฐานข้อมูลประเพณีท้องถิ่น</span>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                <img data-id="2" src="{{ url('frontend-assets/assets/icon/kl_02.png') }}" class="img-responsive center-block active-img">
                <span>ประเพณี</span>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                <img data-id="3" src="{{ url('frontend-assets/assets/icon/kl_03.png') }}" class="img-responsive center-block active-img">
                <span>ศิลปะพื้นถิ่น</span>
            </div>
            <div class="col-lg-3 col-md-3 col-xs-3 col-sm-3">
                <img data-id="4" src="{{ url('frontend-assets/assets/icon/kl_04.png') }}" class="img-responsive center-block active-img">
                <span>ข้อมูลนามานุกรมวรรณคดีไทย</span>
            </div>
        </div>
    </section>

    <section id="nav-menu">
        <div class="nav-menu">
            <img src="{{ url('frontend-assets/assets/icon/navmenu_kl.png') }}" class="img-responsive">
            <h4 style="color: #783D9B;">องค์ความรู้</h4> <h4 style="color: #CA3E9E;">ฐานข้อมูลประเพณีท้องถิ่น</h4>
            <hr />
        </div>
    </section>

    <section id="knowledge-body">
        <div class="row">

        </div>
    </section>

    <section id="knowledge-pagi" style="margin-top: 15px;">
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

@include('shared.modal-knowledge')

@endsection
@section('script')
<script>
// preload window
$(document).ready(function() {
    blank_bg();
    get_knowledge(1);
});
</script>
@endsection
