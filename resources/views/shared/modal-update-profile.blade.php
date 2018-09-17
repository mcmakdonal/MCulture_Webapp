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
                <div class="col-md-6 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="USER_FULLNAME" class="control-label">ชื่อ นามสกุล : </label>
                        <input type="text" class="form-control" name="USER_FULLNAME" id="USER_FULLNAME" placeholder="ชื่อ นามสกุลผู้ใช้งาน" required>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="USER_EMAIL" class="control-label">อีเมล : </label>
                        <input type="email" class="form-control" name="USER_EMAIL" id="USER_EMAIL" placeholder="อีเมลผู้ใช้งาน" readonly required>
                    </div>
                </div>

                <div class="col-md-6 col-xs-12 col-sm-12">
                    <div class="form-group">
                        <label for="USER_PHONENUMBER" class="control-label">หมายเลขโทรศัพท์ : </label>
                        <input type="text" class="form-control number-on" name="USER_PHONENUMBER" id="USER_PHONENUMBER" required>
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