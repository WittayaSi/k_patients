@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-success">
                <div class="panel-heading">
                    <center><p><h3>หน้าหลัก</h3></p></center>
                </div>
                <div class="panel-body">
                    
                    <!-- sub panel 1 -->
                    <div class="col-md-10 col-md-offset-1">
                        <div class="panel panel-success">
                            <div class="panel-heading">
                                ผู้ป่วยนัดวันนี้
                            </div>
                            <div class="panel-body">
                                ตาราง
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
@endsection
