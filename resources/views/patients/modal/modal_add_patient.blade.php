<!-- Modal -->
    <div class="modal fade" ref="modalAddPatient" id="modalAddPatient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="#" @submit.prevent="addNewPatient">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header alert alert-success">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus fa-lg"></i>&nbsp&nbsp ข้อมูลผู้ป่วยรายใหม่</h4></center>
                </div>
                <!--start create-->
                <div class="modal-body">
                    <!-- form input-->
                    <div class="row">
                        <input type="hidden" ref="user_id_add" value="<?php echo Auth::user()->id; ?>">
                        <div class="form-group col-md-5">
                            <label for="hospcode">สถานบริการที่รับผิดชอบ</label>
                            <select name="hospcode" v-model="newPatient.hospcode" class="form-control" id="hospcode" required='required'>
                                <option  value="">เลือกสถานบริการ</option>
                                <option v-for="h in hospital" :value="h.hoscode">@{{ h.hoscode }}-@{{ h.hosname }}</option>
                            </select>
                        </div>
                        <div class="form-group{{ $errors->has('idNo') ? ' has-error' : '' }} col-md-5">
                            <label for="idNo">เลขบัตรประชาชน</label>
                            <input type="text" name="idNo" v-model="newPatient.idNo" class="form-control" id="idNo" placeholder="กรอกเลขบัตรประชาชน" required="required" maxlength="13" minlength="13">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="hn">รหัส HN</label>
                            <input type="text" name="hn" v-model="newPatient.hn" class="form-control" id="hn" :disabled="true">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="first_sick">อาการแรกรับ</label>
                            <select name="first_sick" v-model="newPatient.first_sick" class="form-control" id="first_sick" required='required'>
                                <option  value="">เลือกอาการแรกรับ</option>
                                <option v-for="p in codes.disease" :value="p.id_disease">@{{ p.id_disease }}-@{{ p.name_disease }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recieve_date">ว/ด/ปี(ค.ศ.) แรกรับ</label>
                            <input type="date" name="recieve_date" v-model="newPatient.recieve_date" class="form-control" id="recieve_date" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="preName">คำนำหน้าชื่อ</label>
                            <select name="preName" v-model="newPatient.preName" class="form-control" id="preName" required='required' @change="changeGender('c')">
                                <option  value="">เลือกคำนำหน้าชื่อ</option>
                                <option v-for="p in codes.preName" :value="p.id_prename">@{{ p.id_prename }}-@{{ p.prename }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fName">ชื่อ</label>
                            <input type="text" name="fName" v-model="newPatient.fName" class="form-control" id="fName" placeholder="กรอกชื่อ" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lName">นามสกุล</label>
                            <input type="text" name="lName" v-model="newPatient.lName" class="form-control" id="lName" placeholder="กรอกนามสกุล" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dob">ว/ด/ปี(ค.ศ.) เกิด</label>
                            <input type="date" name="dob" v-model="newPatient.dob" class="form-control" id="dob" required="required">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="sex">เพศ</label>
                            <select class="form-control" name="sex" v-model="newPatient.sex" id="sex" :disabled="true">
                                <option :value="newPatient.sex">@{{txtSex}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="race">เชื้อชาติ</label>
                            <select class="form-control" name="race" v-model="newPatient.race" id="race" required="required">
                                <option value="">เชื้อชาติ</option>
                                <option v-for="o in codes.nation" :value="o.mapnation">@{{o.mapnation}}-@{{o.nationname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="nation">สัญชาติ</label>
                            <select class="form-control" name="nation" v-model="newPatient.nation" id="nation" required="required">
                                <option value="">สัญชาติ</option>
                                <option v-for="o in codes.nation" :value="o.mapnation">@{{o.mapnation}}-@{{o.nationname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="mStatus">สถานภาพสมรส</label>
                            <select class="form-control" name="mStatus" v-model="newPatient.mStatus" id="mStatus" required="required">
                                <option value="">สถานภาพสมรส</option>
                                <option v-for="m in codes.mStatus" :value="m.mapmstatus">@{{m.mapmstatus}}-@{{m.mstatusname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="education">การศึกษา</label>
                            <select class="form-control" name="education" v-model="newPatient.education" id="education" required="required">
                                <option value="">การศึกษา</option>
                                <option v-for="c in codes.education" :value="c.mapeducation">@{{c.mapeducation}}-@{{c.educationname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="occupation">อาชีพ</label>
                            <select class="form-control" name="occupation" v-model="newPatient.occupation" id="occupation" required="required">
                                <option value="">อาชีพ</option>
                                <option v-for="o in codes.occupation" :value="o.mapoccupation">@{{o.mapoccupation}}-@{{o.occupationname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="religion">ศาสนา</label>
                            <select class="form-control" name="religion" v-model="newPatient.religion" id="religion" required="required">
                                <option value="">ศาสนา</option>
                                <option v-for="o in codes.religion" :value="o.mapreligion">@{{o.mapreligion}}-@{{o.religionname}}</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="address_no">บ้านเลขที่</label>
                            <input type="text" name="address_no" v-model="newPatient.address_no" class="form-control" id="address_no" placeholder="กรอกบ้านเลขที่" required="required">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="moo">หมู่ที่</label>
                            <input type="text" name="moo" v-model="newPatient.moo" class="form-control" id="moo" placeholder="กรอกหมู่ที่" required="required">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="village">ชื่อหมู่บ้าน</label>
                            <input type="text" name="village" v-model="newPatient.village" class="form-control" id="village" placeholder="กรอกชื่อหมู่บ้าน" required="required">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="tambon">ตำบล</label>
                            <select class="form-control" name="tambon" v-model="newPatient.tambon" id="tambon" required="required">
                                <option value="">เลือกตำบล</option>
                                <option v-for="o in codes.tambon" :value="o.maptambon">@{{o.maptambon}}-@{{o.tambonname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="ampur">อำเภอ</label>
                            <select class="form-control" name="ampur" v-model="newPatient.ampur" id="ampur" required="required">
                                <option value="">เลือกอำเภอ</option>
                                <option value="05">05-ท่าสองยาง</option>
                                <option value="99">99-ไม่ระบุ</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="changwat">จังหวัด</label>
                            <select class="form-control" name="changwat" v-model="newPatient.changwat" id="changwat" required="required">
                                <option value="">เลือกจังหวัด</option>
                                <option value="63">63-ตาก</option>
                                <option value="99">99-ไม่ระบุ</option>
                            </select>
                        </div>
                    </div>
                    <!-- end form input-->

                </div>
                <!--end create-->

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