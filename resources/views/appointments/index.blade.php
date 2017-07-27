@extends('layouts.app')

@section('content')

<div class="container">
    <div id="vueApp">

        @include('appointments.modal.modal_view_patient')
        @include('appointments.modal.modal_add_appointment')

        
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div id="calendar">
                    <center>
                        <a data-toggle="modal" data-target="#modalAppointment_c" class="btn btn-primary">
                            <i class="fa fa-address-book fa-fw"></i> นัดหมายผู้ป่วยเพิ่ม
                        </a>
                    </center>
                    {!! $calendar->calendar() !!}
                    {!! $calendar->script() !!}
                </div>
            </div>
        </div>

    </div>
</div>

@endsection

@push('scripts')
    <script>
        var hos_ref = {!! json_encode($hos_ref) !!}
        var doctor = {!! json_encode($doctor) !!}
        var patient = {!! json_encode($patient) !!}
        
    </script>
    <script src="{{ asset('/js/appointments/index.js') }}"></script>
@endpush

