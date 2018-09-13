@extends('master.web-app')

@section('title', $title )

@section('content')

<section>
    <img src="{{ asset('frontend-assets/assets/imgs/head_comment.jpg' )}}" class="img-responsive center-block">
</section>

<section id="commentform">

    <div class="container">

    {!! Form::open(['url' => '/form/commentform','class' => 'form-auth-small', 'method' => 'post','id' => 'form-form','files'=> true] ) !!}

        <div class="row">
            <div class="col-md-12 col-xs-12 col-sm-12">
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

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="CMTYPE_ID" class="control-label">ประเภท <span class="must-input">*</span> : </label>
                    <select class="form-control use-select2" id="CMTYPE_ID" name="CMTYPE_ID" required>
                        @foreach ($select as $value)
                        <option value="{{$value->cmtype_id}}">{{$value->cmtype_name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="CMDATA_NAME" class="control-label">หัวข้อ <span class="must-input">*</span> : </label>
                    <input type="text" class="form-control" id="CMDATA_NAME" name="CMDATA_NAME" value="" placeholder="หัวข้อ" required>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="CMDATA_DETAILS" class="control-label">แสดงความคิดเห็น/รายละเอียด <span class="must-input">*</span> : </label>
                    <textarea class="form-control" style="resize: none;" rows="3" id="CMDATA_DETAILS" name="CMDATA_DETAILS" required></textarea>
                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <div class="form-group">
                    <label for="CMDATA_PERSONNAME" class="control-label">ขื่อบุคลากร <span class="must-input">*</span> : </label>
                    <input type="text" class="form-control" name="CMDATA_PERSONNAME" id="CMDATA_PERSONNAME" required>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="register" role="dialog">
                <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                    <h4 class="modal-title">กรอกข้อมูล</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label for="USER_FULLNAME" class="control-label">ชื่อ นามสกุลผู้ใช้งาน <span class="must-input">*</span> : </label>
                                    <input type="text" class="form-control" id="USER_FULLNAME" name="USER_FULLNAME" value="" placeholder="ชื่อ นามสกุลผู้ใช้งาน">
                                </div>
                            </div>

                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label for="USER_EMAIL" class="control-label">อีเมลผู้ใช้งาน <span class="must-input">*</span> : </label>
                                    <input type="email" class="form-control" id="USER_EMAIL" name="USER_EMAIL" value="" placeholder="อีเมลผู้ใช้งาน">
                                </div>
                            </div>

                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <label for="USER_PHONENUMBER" class="control-label">หมายเลขโทรศัพท์ผู้ใช้งาน <span class="must-input">*</span> : </label>
                                    <input type="text" class="form-control number-on" name="USER_PHONENUMBER" id="USER_PHONENUMBER">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success submit-color">ส่งข้อมูล</button>
                    </div>
                </div>

                </div>
            </div>

            <div class="col-md-12 col-xs-12 col-sm-12">
                <?=link_to('/', $title = 'ยกเลิก', ['class' => 'col-xs-4 btn btn-warning can-color'], $secure = null);?>
                <button type="button" class="btn btn-success col-xs-8 inform-form-check submit-color">ส่งข้อมูล</button>
            </div>
        </div>

    {!! Form::close() !!}

    </div>

</section>
 @endsection