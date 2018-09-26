@extends('master.web-app')

@section('title', $title )

@section('content')
<div class="">
    <section id="section-history" style="margin-top: 60px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel-group" id="accordion">
                    
                    @foreach($obj as $k => $v)
                    <div class="panel panel-default panel-history">
                        <div class="panel-heading">
                            <h4 class="panel-title">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse{{ $k }}">{{ $v->topic_title }}</a>
                            </h4>
                            <p>{{ $v->topic_details }}</p>
                            <p>ประเภท : {{ $v->topic_main_type_name }} | {{ $v->topic_sub_type_name }}</p>
                            <p>วันที่แจ้ง : {{ $v->topic_title }}</p>
                        </div>
                        <div id="collapse{{ $k }}" class="panel-collapse collapse">
                            <div class="panel-body">
                                
                                @if(count($v->reply) == 0)
                                    <div class="text-center none-reply">ยังไม่มีการตอบกลับ</div>
                                @endif

                                @foreach($v->reply as $kk => $vv)
                                <div class="media">
                                    <div class="media-body no-top">
                                        <p>{{ $vv->reply_details }}</p>
                                        <p>วันที่ : </p>
                                    </div>
                                    <div class="media-right text-center" style="vertical-align: middle;">
                                        <img src="{{ url('frontend-assets/assets/icon/reply.png') }}" class="media-object" style="width:60px">
                                        <span style="color: white;">เจ้าหน้าที่</span>
                                    </div>
                                </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                    @endforeach

                </div> 
            </div>
        </div>
    </section>
</div>
@endsection