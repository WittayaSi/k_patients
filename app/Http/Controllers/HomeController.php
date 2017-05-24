<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Patient;
use App\Appointment;
use KS\Line\LineNotify;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function getNowAppoint()
    {
        $date_now = date('Y-m-d');

        $appoint_now = DB::select('
            select a.*, d.*,c.id_doctor, c.name_doctor
            from appointments as a
            left join (
                select p.*, cp.detail
                from patients as p
                left join cprenames as cp on (cp.id_prename = p.prename)
            ) as d on (d.id_no = a.id_no)
            left join doctors c on (c.id_doctor = a.doctor_id)
            where a.app_date = "' . $date_now . '"
            order by c.id_doctor ASC'
        );


        $res = [
            'rawData' => $appoint_now,
            'date_now' => $date_now
        ];

        return response()->json($res);
    }

    public function lineNotify()
    {
        $date_tomorow = date('Y-m-d', strtotime('tomorrow'));

        $appoint_tomorrow = DB::select('
            select a.*, d.*,c.id_doctor, c.name_doctor
            from appointments as a
            left join (
                select p.*, cp.detail
                from patients as p
                left join cprenames as cp on (cp.id_prename = p.prename)
            ) as d on (d.id_no = a.id_no)
            left join doctors c on (c.id_doctor = a.doctor_id)
            where a.app_date = "' . $date_tomorow . '"
            order by c.id_doctor ASC'
        );

        $content = "";
        foreach($appoint_tomorrow as $a){
            $content = $content . ($a->detail).($a->name).' '.($a->lname).', ';
        }

        $app_no = count($appoint_tomorrow);

        // line notify 
        if($app_no > 0) {

            $token = 'GNYga83I4mg9roJYc8C2NXGlGb42dCDUDFUUVLwRZWF';
            $ln = new LineNotify($token);

            $message = $message = 'พรุ่งนี้ '. $date_tomorow .' มีนัดหมาย จำนวน ' . $app_no . ' คน คือ ' .
                       $content;
            $ln->send($message);

        }
        //end line notify

        $res = [
            'rawData' => $appoint_tomorrow,
            'date_tomorrow' => $date_tomorow,
            'app_no' => $app_no,
            'message' => $message
        ];

        return response()->json($res);
    }
}
