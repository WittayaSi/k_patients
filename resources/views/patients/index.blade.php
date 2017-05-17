@extends('layouts.app')

@section('content')
<div class="container">
    <div id="vueApp">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <center><p><h3>ข้อมูลผู้ป่วย</h3></p></center>
                    </div>
                    <div class="panel-body">
                        
                        <!-- sub panel 1 -->
                        <div class="col-md-10 col-md-offset-1">
                            <div class="panel panel-success">
                                <div class="panel-heading">
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
                                    ตาราง
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
  <script src="{{ asset('/js/search.js') }}"></script>
@endpush
