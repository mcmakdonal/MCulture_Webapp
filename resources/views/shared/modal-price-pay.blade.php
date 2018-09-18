            <!-- Modal -->
            <div class="modal fade" id="price" role="dialog">
                <div class="modal-dialog">
                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                            <h4 class="modal-title" style="color: black;">กำหนดราคา</h4>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <p class="text-warning text-center" style="display: none;" id="warning">ไม่สามารถกำหนดค่า ราคา ให้ซ้ำประเภทได้ กรุณาตรวจสอบอีกครั้ง</p>
                                </div>
                                <div class="col-md-12 col-xs-12 col-sm-12">
                                    <table class="table table-hover" id="price-table">
                                        <thead>
                                            <tr>
                                                <th>ประเภท</th>
                                                <th>ราคา</th>
                                                <th>ลบ</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-primary" onclick="add_price_row()">เพิ่ม </button>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
                        </div>
                    </div>
                </div>
            </div>
