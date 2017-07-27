<!-- Modal Add Appointment-->
<div class="modal fade" id="modalAppointment_c" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <form action="#" @submit.prevent="addNewAppoint">
    {{ csrf_field() }}
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header alert alert-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus fa-lg"></i>&nbsp&nbsp เพิ่มการนัดหมาย</h4></center>
            </div>
            <div class="modal-body">
                <!-- form input-->
                <!--<div class="fetched-data"></div>-->
                <div class="row">
                    <input type="hidden" ref="user_id" value="<?php echo Auth::user()->id; ?>">
                    <div class="form-group col-md-12">
                        <label for="id_no">ชื่อผู้ป่วย</label>
                        <select name="id_no" v-model="newApp.id_no" class="form-control" id="id_no" required='required'>
                            <option  value="">เลือกชื่อผู้ป่วย</option>
                            <option v-for="p in codes.c_patient" :value="p.id_no">( @{{ p.hn }}) - @{{ p.detail }}@{{ p.name }} @{{ p.lname }}</option>
                        </select>
                    </div>

                    <div class="form-group col-md-5">
                        <label for="hosp_ref">โรงพยาบาลที่นัด</label>
                        <select name="hosp_ref" v-model="newApp.hosp_ref" class="form-control" id="hosp_ref" required='required'>
                            <option  value="">เลือกโรงพยาบาล</option>
                            <option v-for="h in codes.c_hos_ref" :value="h.hoscode">@{{ h.hoscode }}-@{{ h.hosname }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-7">
                        <label for="app_doctor">แพทย์ผู้นัด</label>
                        <select name="app_doctor" v-model="newApp.doctor" class="form-control" id="app_doctor" required='required'>
                            <option  value="">เลือกแพทย์</option>
                            <option v-for="c in codes.c_doctor" :value="c.id_doctor">@{{ c.id_doctor }}-@{{ c.name_doctor }}</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="app_date">ว/ด/ปี(ค.ศ.) ที่นัด</label>
                        <input type="date" name="app_date" v-model="newApp.app_date" class="form-control" id="app_date" required="required">
                    </div>
                    <div class="form-group col-md-8">
                        <label for="app_detail">รายละเอียดการนัด</label>
                        <input type="text" name="app_detail" v-model="newApp.app_detail" class="form-control" id="app_detail" placeholder="รายละเอียดการนัด" required="required">
                    </div>
                    <div class="form-group col-md-12">
                        <label for="app_other">หมายเหตุ</label>
                        <textarea cols="5" rows="5" name="app_other" v-model="newApp.app_other" class="form-control" id="app_other" placeholder="หมายเหตุ" required="required"></textarea>
                    </div>
                </div>
                <!-- end form input-->

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