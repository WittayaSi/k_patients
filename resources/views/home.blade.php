@extends('layouts.app')

@section('content')
<div class="container">
    <div id="vueApp">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <center><p><h3>หน้าหลัก</h3></p></center>
                </div>
                <div class="panel-body">
                    
                    <!-- sub panel 1 -->
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <b>ผู้ป่วยนัดวันนี้ ( @{{ date_now | getDate }} )</b>
                            </div>
                            <div class="panel-body">
                                
                                <div class="table-responsive" v-if="app_now != ''">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="alert-warning">
                                                <th style="text-align: center">รหัสสถาบริการ</th>
                                                <th style="text-align: center">รหัส HN</th>
                                                <th style="text-align: center">ชื่อ - สกุล</th>
                                                <th style="text-align: center">แพทย์</th>
                                                <th style="text-align: center">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="a in app_now">
                                                <td width="15%" style="text-align: center">@{{a.hospcode}}</td>
                                                <td width="10%" style="text-align: center">@{{a.hn}}</td>
                                                <td width="30%">@{{a.detail}}@{{a.name}} @{{a.lname}}</td>
                                                <td width="30%">@{{a.name_doctor}}</td>
                                                <td width="15%" style="text-align: center">
                                                    <div class="btn-group">
                                                        <button type="button" class="btn btn-warning btn-sm"><i class="fa fa-pencil-square-o"></i></button>
                                                        @if(Auth::user()->is_admin === 'Y')
                                                            <button type="button" class="btn btn-danger btn-sm" @click="deleteAppoint(a.id)"><i class="fa fa-trash"></i></button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div v-else style="text-align: center">
                                    วันนี้ไม่มีนัด
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end sub panel 1 -->

                    <!-- sub panel 2 -->
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <b>ผู้ป่วยนัดพรุ่งนี้ ( @{{ date_tomorrow | getDate }} )</b>
                            </div>
                            <div class="panel-body">
                                
                                <div class="table-responsive" v-if="app_tomorrow != ''">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="alert-success">
                                                <th style="text-align: center">รหัสสถาบริการ</th>
                                                <th style="text-align: center">รหัส HN</th>
                                                <th style="text-align: center">ชื่อ - สกุล</th>
                                                <th style="text-align: center">แพทย์</th>
                                                <th style="text-align: center">จัดการ</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="a in app_tomorrow">
                                                <td width="15%" style="text-align: center">@{{a.hospcode}}</td>
                                                <td width="10%" style="text-align: center">@{{a.hn}}</td>
                                                <td width="30%">@{{a.detail}}@{{a.name}} @{{a.lname}}</td>
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

                                <div v-else style="text-align: center">
                                    พรุ่งนี้ไม่มีนัด
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- end sub panel 2 -->

                    <!-- sub panel 3 -->
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-warning">
                            <div class="panel-heading">
                                <b>รายงานการนัดตรวจวันนี้ ( @{{ date_now | getDate }} )</b>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive" v-if="g_b_doctor_today != ''">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="alert-warning">
                                                <th style="text-align: center">รหัส</th>
                                                <th style="text-align: center">แพทย์</th>
                                                <th style="text-align: center">จำนวน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="d in g_b_doctor_today">
                                                <td width="20%" style="text-align: center">@{{d.id_doctor}}</td>
                                                <td width="40%" style="text-align: center">@{{d.name_doctor}}</td>
                                                <td width="40%" style="text-align: center">@{{d.no_count}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div v-else style="text-align: center">
                                    วันนี้ไม่มีนัด
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end sub panel 3 -->

                    <!-- sub panel 4 -->
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                <b>รายงานการนัดตรวจพรุ่งนี้ ( @{{ date_tomorrow | getDate }} )</b>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive" v-if="g_b_doctor_tomorrow != ''">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="alert-success">
                                                <th style="text-align: center">รหัส</th>
                                                <th style="text-align: center">แพทย์</th>
                                                <th style="text-align: center">จำนวน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="d in g_b_doctor_tomorrow">
                                                <td width="20%" style="text-align: center">@{{d.id_doctor}}</td>
                                                <td width="40%" style="text-align: center">@{{d.name_doctor}}</td>
                                                <td width="40%" style="text-align: center">@{{d.no_count}}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div v-else style="text-align: center">
                                   พรุ่งนี้ไม่มีนัด
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end sub panel 4 -->

                </div>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection

@push('scripts')
    <script src="{{ asset('/js/home/home.js') }}"></script>
@endpush
