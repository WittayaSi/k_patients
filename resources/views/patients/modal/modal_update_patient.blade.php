<!-- Modal -->
    <div class="modal fade" ref="modalUpdatePatient" id="modalUpdatePatient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <form action="#" @submit.prevent="updatePatientF">
        {{ csrf_field() }}
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header alert alert-warning">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <center><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus fa-lg"></i>&nbsp&nbsp แก้ไขข้อมูลผู้ป่วย</h4></center>
                </div>

                
                <!--start edit-->
                <div class="modal-body" v-for="pData in ind_patient">
                    <!-- form input-->
                    <div class="row">
                        <input type="hidden" ref="user_id_add" value="<?php echo Auth::user()->id; ?>">
                        <input type="hidden" ref="patient_id" :value="pData.id_no">
                        <div class="form-group col-md-5">
                            <label for="hospcode">สถานบริการที่รับผิดชอบ</label>
                            <select ref="hospcodeE" name="hospcodeE" class="form-control" id="hospcodeE" required='required'>
                                 <option v-for="h in hospital" :value="h.hoscode" :selected="pData.hospcode === h.hoscode">@{{ h.hoscode }}-@{{ h.hosname }}</option>
                            </select>
                        </div>
                        <div class="form-group{{ $errors->has('idNo') ? ' has-error' : '' }} col-md-5">
                            <label for="idNoE">เลขบัตรประชาชน</label>
                            <input type="text" name="idNoE" ref="idNoE" class="form-control" id="idNoE" :value="pData.id_no" required="required" maxlength="13" minlength="13">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="hnE">รหัส HN</label>
                            <input type="text" name="hn" ref="hnE" :value="pData.hn" class="form-control" id="hnE" :disabled="true">
                        </div>
                        <div class="form-group col-md-8">
                            <label for="first_sickE">อาการแรกรับ</label>>
                            <select name="first_sickE" ref="first_sickE"  class="form-control" id="first_sickE" required='required'>
                                <option v-for="p in codes.disease" :value="p.id_disease" :selected="pData.first_sick === p.id_disease ? true : false">@{{ p.id_disease }}-@{{ p.name_disease }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="recieve_dateE">ว/ด/ปี(ค.ศ.) แรกรับ</label>
                            <input type="date" name="recieve_dateE" :value="pData.recieve_date" ref="recieve_dateE" class="form-control" id="recieve_dateE" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="preNameE">คำนำหน้าชื่อ</label>
                            <select name="preNameE" ref="preNameE" class="form-control" id="preNameE" required='required' @change="changeGender('e')">
                                <option v-for="p in codes.preName" :value="p.id_prename" :selected="pData.prename === p.id_prename">@{{ p.id_prename }}-@{{ p.prename }}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="fNameE">ชื่อ</label>
                            <input type="text" name="fNameE" ref="fNameE" :value="pData.name" class="form-control" id="fNameE" placeholder="กรอกชื่อ" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="lNameE">นามสกุล</label>
                            <input type="text" name="lNameE" ref="lNameE" :value="pData.lname" class="form-control" id="lNameE" placeholder="กรอกนามสกุล" required="required">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="dobE">ว/ด/ปี(ค.ศ.) เกิด</label>
                            <input type="date" name="dobE" ref="dobE" :value="pData.birth" class="form-control" id="dob" required="required">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="sexE">เพศ</label>
                            <select class="form-control" name="sexE" ref="sexE" id="sexE" :disabled="true">
                                <option :value="pData.sex">@{{txtSex}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="raceE">เชื้อชาติ</label>
                            <select class="form-control" name="raceE" ref="raceE" id="raceE" required="required">
                                <option v-for="o in codes.nation" :value="o.mapnation" :selected="pData.race === o.mapnation?true:false">@{{o.mapnation}}-@{{o.nationname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="nationE">สัญชาติ</label>
                            <select class="form-control" name="nationE" ref="nationE" id="nationE" required="required">
                                <option value="">สัญชาติ</option>
                                <option v-for="o in codes.nation" :value="o.mapnation" :selected="pData.nation === o.mapnation?true:false">@{{o.mapnation}}-@{{o.nationname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="mStatusE">สถานภาพสมรส</label>
                            <select class="form-control" name="mStatusE" ref="mStatusE" id="mStatusE" required="required">
                                <option value="">สถานภาพสมรส</option> 
                                <option v-for="m in codes.mStatus" :value="m.mapmstatus" :selected="pData.mstatus === m.mapmstatus?true:false">@{{m.mapmstatus}}-@{{m.mstatusname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="educationE">การศึกษา</label>
                            <select class="form-control" name="educationE" ref="educationE" id="educationE" required="required">
                                <option value="">การศึกษา</option>
                                <option v-for="c in codes.education" :value="c.mapeducation" :selected="pData.education === c.mapeducation?true:false">@{{c.mapeducation}}-@{{c.educationname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="occupationE">อาชีพ</label>
                            <select class="form-control" name="occupationE" ref="occupationE" id="occupationE" required="required">
                                <option value="">อาชีพ</option>
                                <option v-for="o in codes.occupation" :value="o.mapoccupation" :selected="pData.occupation === o.mapoccupation?true:false">@{{o.mapoccupation}}-@{{o.occupationname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="religionE">ศาสนา</label>
                            <select class="form-control" name="religionE" ref="religionE" id="religionE" required="required">
                                <option value="">ศาสนา</option>
                                <option v-for="o in codes.religion" :value="o.mapreligion" :selected="pData.religion === o.mapreligion?true:false">@{{o.mapreligion}}-@{{o.religionname}}</option>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="form-group col-sm-4">
                            <label for="address_noE">บ้านเลขที่</label>
                            <input type="text" name="address_noE" ref="address_noE" :value="pData.add_no" class="form-control" id="address_noE" placeholder="กรอกบ้านเลขที่" required="required">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="mooE">หมู่ที่</label>
                            <input type="text" name="mooE" ref="mooE" :value="pData.moo" class="form-control" id="mooE" placeholder="กรอกหมู่ที่" required="required">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="villageE">ชื่อหมู่บ้าน</label>
                            <input type="text" name="villageE" ref="villageE" :value="pData.vill_name" class="form-control" id="villageE" placeholder="กรอกชื่อหมู่บ้าน" required="required">
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="tambonE">ตำบล</label>
                            <select class="form-control" name="tambonE" ref="tambonE" id="tambonE" required="required">
                                <option value="">เลือกตำบล</option>
                                <option v-for="o in codes.tambon" :value="o.maptambon" :selected="pData.tambon === o.maptambon?true:false">@{{o.maptambon}}-@{{o.tambonname}}</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="ampurE">อำเภอ</label>
                            <select class="form-control" name="ampurE" ref="ampurE" id="ampurE" required="required">
                                <option value="05" :selected="pData.ampur === '05'">05-ท่าสองยาง</option>
                                <option value="99" :selected="pData.ampur === '99'">99-ไม่ระบุ</option>
                            </select>
                        </div>
                        <div class="form-group col-sm-4">
                            <label for="changwatE">จังหวัด</label>
                            <select class="form-control" name="changwatE" ref="changwatE" id="changwatE" required="required">
                                <option value="63" :selected="pData.changwat === '63'">63-ตาก</option>
                                <option value="99" :selected="pData.changwat === '99'">99-ไม่ระบุ</option>
                            </select>
                        </div>
                    </div>
                    <!-- end form input-->

                </div>
                <!--end edit-->

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