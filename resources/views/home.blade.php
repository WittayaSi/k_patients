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
                                ผู้ป่วยนัดวันนี้
                            </div>
                            <div class="panel-body">
                                
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover">
                                        <thead>
                                            <tr class="alert-info">
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
                    </div>
                    <!-- end sub panel 1 -->
                    <!-- sub panel 2 -->
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                รายงานการนัดตรวจ
                            </div>
                            <div class="panel-body">
                                ตาราง
                            </div>
                        </div>
                    </div>
                    <!-- end sub panel 2 -->

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
