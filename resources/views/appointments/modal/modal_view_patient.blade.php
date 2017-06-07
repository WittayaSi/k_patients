<!-- Modal Add Appointment-->
<div class="modal fade" id="modalViewPatient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="#" @submit.prevent="addNewAppoint">
    {{ csrf_field() }}
    <div class="modal-dialog">
        <!-- Modal content -->
        <div class="modal-content">
            <div class="modal-header alert alert-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus fa-lg"></i>&nbsp&nbsp ประวัติผู้ป่วย</h4></center>
            </div>

            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="reset" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> ยกเลิก</button>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-save fa-fw"></i> บันทึก</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    </form>
<!-- /.modal-dialog -->
</div>
<!-- end modal -->
