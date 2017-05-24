<div class="modal fade" id="modalViewPatient" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" v-for="p in ind_patient">
            <div class="modal-header alert alert-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus fa-lg"></i>&nbsp&nbsp ประวัติผู้ป่วย</h4></center>
            </div>
            <div class="modal-body">                

                <!-- Patient detail -->
                <div class="row">
                    <div class="col-md-3">
                        <a href="#" class="thumbnail">
                            <img src="{{asset('images/thumbnail.jpg')}}" alt="thumbnail.jpg" width="225px">
                        </a>
                        <center><input type="file" class="btn btn-primary btn-sm" style="width: 150px;"></center>
                    </div>
                    
                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hospname">รพ.สต.ที่รับผิดชอบ</label>
                                    <div name="hospname">@{{ p.hosname }} ( @{{ p.hospcode }} )</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="hn_code">รหัส HN</label>
                                    <div name="hn_code">@{{ p.hn }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fullName">ชื่อ - สกุล</label>
                                    <div name="fullName">@{{ p.detail }}@{{ p.name }} @{{ p.lname }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="dob">ว / ด / ปี เกิด ( อายุ )</label>
                                    <div name="dob">@{{ p.birth | getDate }} ( @{{ p.ages }} ปี )</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nation">สัญชาติ</label>
                                    <div name="nation">@{{ p.nationname }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="educate">การศึกษา</label>
                                    <div name="educate">@{{ p.educationname }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="occup">อาชีพ</label>
                                    <div name="occup">@{{ p.occupationname }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="address">ที่อยู่</label>
                                    <div name="address">
                                        เลขที่ @{{ p.add_no }} 
                                        หมู่ที่ @{{ p.moo }} <br>
                                        @{{ p.vill_name }} <br> @{{ p.tambonname }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <!-- Last 3 treatments -->
                    <center>
                    <div class="panel panel-info" style="width: 95%;">
                        <div class="panel-heading">
                            รายละเอียดการรักษา
                            <a class="pull-right btn btn-primary btn-sm" style="margin-top: -20px;"><i class="fa fa-address-book fa-fw"></i> เพิ่มข้อมูลการรักษา</a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="alert-info">
                                            <th style="text-align: center">วันที่รักษา</th>
                                            <th style="text-align: center">อาการ</th>
                                            <th style="text-align: center">การรักษา</th>
                                            <th style="text-align: center">สถานะ</th>
                                            <th style="text-align: center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="15%" style="text-align: center"></td>
                                            <td width="25%"></td>
                                            <td width="25%"></td>
                                            <td width="20%"></td>
                                            <td width="15%" style="text-align: center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></button>
                                                    @if(Auth::user()->is_admin === 'Y')
                                                        <button type="button" class="btn btn-danger btn-sm" @click="deletePatient(p.id_no)"><i class="fa fa-trash"></i></button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- End last 3 treatments -->
                </div>

                <hr>
                <div class="row">
                    <!-- Last 3 appointment table  -->
                    <center>
                    <div class="panel panel-success" style="width: 80%;">
                        <div class="panel-heading">
                            รายการนัดหมาย 3 ครั้งหลังสุด
                            <a data-toggle="modal" data-target="#modalAppointment" class="pull-right btn btn-primary btn-sm" style="margin-top: -20px;"><i class="fa fa-address-book fa-fw"></i> นัดหมายเพิ่ม</a>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr class="alert-info">
                                            <th style="text-align: center">วันนัด</th>
                                            <th style="text-align: center">รายการ</th>
                                            <th style="text-align: center">แพทย์</th>
                                            <th style="text-align: center">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="a in appointments">
                                            <td width="25%" style="text-align: center">@{{a.app_date | getDate}}</td>
                                            <td width="30%">@{{a.app_detail}}</td>
                                            <td width="30%">@{{a.name_doctor}}</td>
                                            <td width="15%" style="text-align: center">
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></button>
                                                    @if(Auth::user()->is_admin === 'Y')
                                                        <button type="button" class="btn btn-danger btn-sm" @click="deletePatient(p.id_no)"><i class="fa fa-trash"></i></button>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    </center>
                    <!-- End last 3 appointment table  -->
                </div>

                <!-- End patient detail-->

            </div>
            <div class="modal-footer">
                <a data-toggle="modal" data-target="#modalMore" class="btn btn-primary pull-right"><i class="fa fa-plus fa-fw"></i> ทดสอบ </a>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
</div>

<div class="modal fade" id="modalMore" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header alert alert-success">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <center><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus fa-lg"></i>&nbsp&nbsp ประวัติผู้ป่วย</h4></center>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Appointment-->
    <div class="modal fade" ref="modalAppointment" id="modalAppointment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
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
                        <div class="form-group col-md-5">
                            <label for="hosp_ref">โรงพยาบาลที่นัด</label>
                            <select name="hosp_ref" v-model="newApp.hosp_ref" class="form-control" id="hosp_ref" required='required'>
                                <option  value="">เลือกโรงพยาบาล</option>
                                <option v-for="h in codes.hos_ref" :value="h.hoscode">@{{ h.hoscode }}-@{{ h.hosname }}</option>
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
                        <input type="hidden" :value="newApp.id_no" name="id_no">
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