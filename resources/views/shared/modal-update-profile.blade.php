<!-- Modal -->
<div class="modal fade" id="update-profile" role="dialog">
    <div class="modal-dialog">
    {!! Form::open(['url' => '/update-profile','class' => 'form-auth-small', 'method' => 'post']) !!}
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" style="color: black;">อัพเดตข้อมูลส่วนตัว</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="communicant_fullname" class="control-label">ชื่อ นามสกุลผู้ใช้งาน <span class="must-input">*</span> : </label>
                        <input type="text" class="form-control" id="communicant_fullname" name="communicant_fullname" value="" placeholder="ชื่อ นามสกุลผู้ใช้งาน">
                    </div>
                </div>

                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="communicant_email" class="control-label">อีเมลผู้ใช้งาน <span class="must-input">*</span> : </label>
                        <input type="email" class="form-control" id="communicant_email" name="communicant_email" value="" placeholder="อีเมลผู้ใช้งาน">
                    </div>
                </div>

                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="communicant_phone" class="control-label">หมายเลขโทรศัพท์ผู้ใช้งาน <span class="must-input">*</span> : </label>
                        <input type="text" class="form-control number-on" name="communicant_phone" id="communicant_phone" placeholder="หมายเลขโทรศัพท์ผู้ใช้งาน" maxlength="50">
                    </div>
                </div>

                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="communicant_identification" class="control-label">เลขบัตรประจำตัวประชาชน <span class="must-input">*</span> : </label>
                        <input type="text" class="form-control number-on" name="communicant_identification" id="communicant_identification" placeholder="เลขบัตรประจำตัวประชาชน" pattern=".{13,}" maxlength="13">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success submit-color">อัพเดตข้อมูล</button>
        </div>
    </div>
    {!! Form::close() !!}
    </div>
</div>