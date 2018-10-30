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
                                        <input type="text" class="form-control number-on" name="communicant_phone" id="communicant_phone" placeholder="หมายเลขโทรศัพท์ผู้ใช้งาน" maxlength="10">
                                    </div>
                                </div>

                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="communicant_identification" class="control-label">เลขบัตรประจำตัวประชาชน <span class="must-input">*</span> : </label>
                                        <input type="text" class="form-control number-on iden" name="communicant_identification" id="communicant_identification" placeholder="เลขบัตรประจำตัวประชาชน" pattern=".{13,}" maxlength="13">
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <a href="https://www.m-culture.go.th/th/doc/Privacy_Policy02.pdf" target="_blank">
                                        <h3 class="text-center" style="color: black;">นโยบายการคุ้มครองข้อมูลส่วนบุคคล</h3>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" onclick="return checkRegis();" class="btn btn-success">ส่งข้อมูล</button>
                        </div>
                    </div>
                </div>
            </div>