<!-- Modal -->
<div class="modal fade" id="nofti-modal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <h4 class="modal-title"> การแจ้งเตือน </h4>
            </div>
            <div class="modal-body">
                <label style="display: block;"> รับการแจ้งเตือน </label>
                <label class="switch">
                    <input type="checkbox" id="nofti" onchange="update_nofti();">
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
            </div>
        </div>
    </div>
</div>