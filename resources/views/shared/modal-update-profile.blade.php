<!-- Modal -->
<div class="modal fade" id="update-profile" role="dialog">
    <div class="modal-dialog">
    {!! Form::open(['url' => url("update-profile") ,'class' => 'form-auth-small', 'method' => 'post','onsubmit' => 'return checkUpdateProfile();']) !!}
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title" style="color: black;">อัพเดตข้อมูลส่วนตัว</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="user_fullname" class="control-label">ชื่อ นามสกุลผู้ใช้งาน <span class="must-input">*</span> : </label>
                        <input type="text" class="form-control" id="user_fullname" name="user_fullname" value="" placeholder="ชื่อ นามสกุลผู้ใช้งาน">
                    </div>
                </div>

                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="user_email" class="control-label">อีเมลผู้ใช้งาน <span class="must-input">*</span> : </label>
                        <input type="email" class="form-control" id="user_email" name="user_email" value="" placeholder="อีเมลผู้ใช้งาน" readonly>
                    </div>
                </div>

                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="user_phone" class="control-label">หมายเลขโทรศัพท์ผู้ใช้งาน <span class="must-input">*</span> : </label>
                        <input type="text" class="form-control number-on" name="user_phone" id="user_phone" placeholder="หมายเลขโทรศัพท์ผู้ใช้งาน" maxlength="10" required>
                    </div>
                </div>

                <div class="col-md-12 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="user_identification" class="control-label">เลขบัตรประจำตัวประชาชน <span class="must-input">*</span> : </label>
                        <input type="text" class="form-control number-on" name="user_identification" id="user_identification" placeholder="เลขบัตรประจำตัวประชาชน" pattern=".{13,}" maxlength="13" required>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <input type="hidden" value="" name="user_identification_blank" id="user_identification_blank">
            <button type="submit" class="btn btn-success submit-color">อัพเดตข้อมูล</button>
        </div>
    </div>
    {!! Form::close() !!}
    </div>
</div>