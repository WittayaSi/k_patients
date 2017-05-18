@extends('layouts.app')

@section('content')
<div class="container">
    <div id="vueApp">

            <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                {{ csrf_field() }}
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header alert alert-success">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <center><h4 class="modal-title" id="myModalLabel"><i class="fa fa-user-plus fa-lg"></i>&nbsp&nbsp ลงทะเบียน</h4></center>
                        </div>
                        <div class="modal-body">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>

                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>

                                    <!--@if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif-->
                                    @if(Session::has('errors'))
                                        <script>
                                            $(document).ready(function(){
                                                $('#myModal').modal({show: true});
                                            })
                                        </script>
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times fa-fw"></i> ยกเลิก</button>
                            <button type="submit" class="btn btn-primary btn-sm" name="form_r"><i class="fa fa-save fa-fw"></i> บันทึก</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
              </form>
            <!-- /.modal-dialog -->
            </div>
            <!-- end modal -->

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <center><p><h3>ข้อมูลผู้ป่วย</h3></p></center>
                    </div>
                    <div class="panel-body">
                        
                        <!-- sub panel 1 -->
                        <div class="col-md-10 col-md-offset-1">
                            <a data-toggle="modal" data-target="#myModal" class="btn btn-primary pull-right" style="margin-top: -10px; margin-right: 10px; cursor:pointer;"><i class="fa fa-plus fa-fw"></i> เพิ่มผู้ป่วย </a>
                            <div class="panel panel-success">
                                <div class="panel-heading">
                                <center><p><h4>ค้นหาผู้ป่วย</h4></p></center>
                                <hr>
                                    <!-- form search patients -->
                                    <div class="row">
                                        <p style="text-align: center">
                                            <input type="radio" v-model="option" value="b"> สถานบริการ &nbsp&nbsp
                                            <input type="radio" v-model="option" value="a"> ชื่อ - นามสกุล
                                        </p>
                                        <p v-if="option === 'b'" class="col-sm-4 col-sm-offset-4">
                                            <label for="hoscode">สถานบริการ</label>
                                            <select class="form-control" name="hoscode" v-model="hoscode" id="hoscode" @change="getPersonById">
                                                <option value="">
                                                    เลือกสถานบริการ
                                                </option>
                                                <option v-for="h in hospital" :value="h.hoscode">@{{h.hoscode}}-@{{h.hosname}}</option>
                                            </select>
                                        </p>
                                        <div v-if="option === 'a'" class="row">
                                            <div class="form-group col-sm-4 col-sm-offset-2">
                                                <label for="txtName">ชื่อ</label>
                                                <input type="text" id="txtName" class="form-control" v-model="txtName" @keyup="getPersonByName" :autofocus="true"/>
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label for="txtLastName">นามสกุล</label>
                                                <input type="text" id="txtLastName" class="form-control" v-model="txtLastName" @keyup="getPersonByLastName"/>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end form search patients--> 
                                </div>
                                <div class="panel-body">
                                    
                                    <!-- search data  -->
                                    <div class="table-responsive">
                                        <table class="table table-bordered table-hover">
                                            <thead>
                                                <tr class="alert-info">
                                                    <th style="text-align: center">เลขประจำตัวผู้ป่วย(HN)</th>
                                                    <th style="text-align: center">ชื่อ - สกุล</th>
                                                    <th style="text-align: center">จัดการ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                    <td style="text-align: center">
                                                        <div class="btn-group">
                                                            <button type="button" class="btn btn-info" aria-label="รายละเอียด"><i class="fa fa-search"></i></button>
                                                            <button type="button" class="btn btn-warning" aria-label="แก้ไข"><i class="fa fa-pencil-square-o"></i></button>
                                                            <button type="button" class="btn btn-danger" aria-label="ลบ"><i class="fa fa-trash"></i></button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end search data  -->
                                    
                                </div>
                            </div>
                        </div>
                        <!-- end sub panel 1 -->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    <script>
        var hospital = {!! json_encode($hospital) !!}
    </script>
    <script src="{{ asset('/js/search.js') }}"></script>
@endpush
