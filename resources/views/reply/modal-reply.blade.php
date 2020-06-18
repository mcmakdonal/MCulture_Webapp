<!-- Modal -->
<div class="modal fade" id="update-profile" role="dialog">
    <div class="modal-dialog">
    {!! Form::open(['url' => url() . 'update-profile','class' => 'form-auth-small', 'method' => 'post']) !!}
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
            </div>
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-success submit-color">อัพเดตข้อมูล</button>
        </div>
    </div>
    {!! Form::close() !!}
    </div>
</div>