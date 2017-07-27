@extends('layouts.app')

@section('content')
<div class="container">
    <div id="vueApp">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <center><p><h3>ข้อมูลผู้ป่วยในพระราชานุเคราะห์ทั้งหมด</h3></p></center>
                    </div>
                    <div class="panel-body">

                        <div class="alert alert-success col-md-10 col-md-offset-1" transition="statusBar" style="text-align: center" v-if="statusBar">
                            เพิ่มข้อมูลผู้ป่วยรายใหม่ สำเร็จ 
                        </div>
                        
                        <!-- sub panel 1 -->
                        <div class="col-md-12">
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                
                                    <!-- form search patients -->
                                    <div class="row">
                                        <p style="text-align: center">
                                            <input type="radio" v-model="option" value="b"> สถานบริการ &nbsp&nbsp
                                            <input type="radio" v-model="option" value="a"> ชื่อ - นามสกุล
                                            @if(Auth::user()->is_admin === 'Y')
                                                <a data-toggle="modal" data-target="#modalAddPatient" class="btn btn-primary pull-right" style="margin-top: -20px; margin-right: 10px; cursor:pointer;" @click="buttonCall = 'create'"><i class="fa fa-plus fa-fw"></i> เพิ่มผู้ป่วยรายใหม่ </a>
                                            @endif
                                        </p>
                                        <p v-if="option === 'b'" class="col-sm-4 col-sm-offset-4">
                                            <label for="hoscode">สถานบริการ</label>
                                            <select class="form-control" name="hoscode" v-model="hoscode" id="hoscode" @change="getPatientByHosId">
                                                <option value="">
                                                    เลือกสถานบริการ
                                                </option>
                                                <option v-for="h in hospital" :value="h.hoscode">@{{h.hoscode}}-@{{h.hosname}}</option>
                                            </select>
                                        </p>
                                        <div v-if="option === 'a'" class="row">
                                            <div class="form-group col-sm-4 col-sm-offset-2">
                                                <label for="txtName">ชื่อ</label>
                                                <input type="text" id="txtName" class="form-control" v-model="txtName" @keyup="getPatientByName" :autofocus="true"/>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="txtLastName">นามสกุล</label>
                                                <input type="text" id="txtLastName" class="form-control" v-model="txtLastName" @keyup="getPatientByLastName"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end form search patients-->
                                </div>
                                <div class="panel-body">
                                    <!-- search data  -->
                                    <div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="alert-info">
                                                    <!--<th style="text-align: center">รหัสสถานบริการ</th>-->
                                                    <th style="text-align: center">รูป</th>
                                                    <th style="text-align: center">HN</th>
                                                    <th style="text-align: center">ชื่อ - สกุล</th>
                                                    <th style="text-align: center">อาการป่วย</th>
                                                    <th style="text-align: center">อายุ(ปี)</th>
                                                    <th style="text-align: center">ที่อยู่</th>
                                                    <th style="text-align: center">จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="p in patients">
                                                    <input id="user_c" type="hidden" :value="p.user_created">
                                                    <!--<td width="10%" style="text-align: center">@{{ p.hospcode }}</td>-->
                                                    <td width="6%" style="text-align: center;" :bgcolor='p.color_code'><img class="img-circle" id="user_img" :src="p.img_name ? 'images/'+p.img_name : 'images/thumbnail.jpg'" width="30" height="30"></td>
                                                    <td width="5%" style="text-align: center">@{{ p.hn }}</td>
                                                    <td width="19%">@{{ p.detail }}@{{ p.name }}  @{{ p.lname }}</td>
                                                    <td width="28%">@{{ p.name_disease | showStringDisease }}</td>
                                                    <td width="5%" style="text-align: center">@{{ p.birth | calAges }}</td>
                                                    <td width="26%">@{{ p.add_no }} หมู่ที่ @{{ p.moo }}  @{{ p.vill_name }} @{{ p.tambonname }}</td>
                                                    <td width="11%" style="text-align: center">
                                                        
                                                        <div class="btn-group">
                                                            <button type="button" id="pShow" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalViewPatient" @click="getPatient(event,p.id_no)"><i class="fa fa-search"></i></button>
                                                            @if(Auth::user()->is_admin === 'Y')
                                                                <button type="button" id="pEdit" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalUpdatePatient" @click="getPatient(event, p.id_no)"><i class="fa fa-pencil-square-o"></i></button>
                                                            
                                                                <button type="button" class="btn btn-danger btn-sm" @click="deletePatient(p.id_no)"><i class="fa fa-trash"></i></button>
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- Pagination -->
                                    <nav class="pull-right">
                                        <ul class="pagination">
                                            <li v-if="pagination.current_page > 1">
                                                <a href="#" aria-label="Previous"
                                                @click.prevent="changePage(pagination.current_page - 1)">
                                                    <span aria-hidden="true">ก่อนหน้า</span>
                                                </a>
                                            </li>
                                            <li v-for="page in pagesNumber"
                                                :class="[ page == isActived ? 'active' : '']">
                                                <a href="#"
                                                @click.prevent="changePage(page)">@{{ page }}</a>
                                            </li>
                                            <li v-if="pagination.current_page < pagination.last_page">
                                                <a href="#" aria-label="Next"
                                                @click.prevent="changePage(pagination.current_page + 1)">
                                                    <span aria-hidden="true">ถัดไป</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </nav>
                                    <!-- End pagination -->
                                    <!-- end search data  -->
                                    
                                </div>
                            </div>
                        </div>
                        <!-- end sub panel 1 -->

                    </div>
                </div>
            </div>
        </div>
        @include('patients.modal.modal_add_patient')
        @include('patients.modal.modal_update_patient')
        @include('patients.modal.modal_view_patient')
    </div>
</div>
@endsection

@push('scripts')
    <script>
        var hospital = {!! json_encode($hospital) !!}
        var hos_ref = {!! json_encode($hos_ref) !!}
        var education = {!! json_encode($edu) !!}
        var mstatus = {!! json_encode($mstatus) !!}
        var nation = {!! json_encode($nation) !!}
        var occupation = {!! json_encode($occup) !!}
        var prename = {!! json_encode($prename) !!}
        var religion = {!! json_encode($religion) !!}
        var tambon = {!! json_encode($tambon) !!}
        var disease = {!! json_encode($disease) !!}
        var hn_str = {!! json_encode($hn_str) !!}
        var doctor = {!! json_encode($doctor) !!}
    </script>

    <script src="{{ asset('/js/patients/index.js') }}"></script>
@endpush