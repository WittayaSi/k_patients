<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Appointment;
use App\Chospitalrefer;
use App\Doctor;


class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
     {
        $this->middleware('auth');
     } 

    public function index()
    {   
        $data['hos_ref'] = Chospitalrefer::all();
        $data['doctor'] = Doctor::all();
        $data['patient'] = DB::table('patients as p')
            ->select('p.id_no', 'p.hn', 'cp.detail', 'p.name', 'p.lname')
            ->leftJoin('cprenames as cp', 'cp.id_prename', '=', 'p.prename')
            ->get();

        $appoints = DB::select('
            select a.*, d.*,c.id_doctor, c.name_doctor
            from appointments as a
            left join (
                select p.*, cp.detail
                from patients as p
                left join cprenames as cp on (cp.id_prename = p.prename)
            ) as d on (d.id_no = a.id_no)
            left join doctors c on (c.id_doctor = a.doctor_id)
            order by c.id_doctor ASC'
        );

        $events = [];

        foreach($appoints as $a){
            $events[] = \Calendar::event(
                $a->detail.$a->name.' '.$a->lname, //event title
                true, //full day event
                $a->app_date, //START TIME
                $a->app_date, //END TIME
                $a->id, //event id
                [
                    'url' => '#'
                ] // url when click
            );
        }

        $data['calendar']= \Calendar::addEvents($events)
                    ->setOptions([
                        'firstDay' => 1,
                        'eventClick' => function(){
                            alert('555555555');
                        }
                    ])->setCallbacks([
                        // 'viewRender' => 'function() {alert("Callbacks!");}'
                    ]);

        // return response()->json($events);
        return view('appointments/index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $appoint = new Appointment();

        $idno = $request['id_no'];

        $appoint->id_no = $request['id_no'];
        $appoint->app_hos = $request['hosp_ref'];
        $appoint->app_date = $request['app_date'];
        $appoint->app_detail = $request['app_detail'];
        $appoint->doctor_id = $request['doctor'];
        $appoint->others = $request['app_other'];

        if($appoint->save()){
            $res = [
                'success' => 'successfully',
                'rawData' => $idno
            ];
            return response()->json($res);
        }else{
            return 'failed';
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
