<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    public function getAllPatient(Request $req){
        $p = DB::table('patients as p')
            ->select('p.id_no', 'p.hospcode', 'ch.hosname', 'p.hn', 'cp.detail', 'p.name', 'p.lname', 'p.birth', 'p.add_no', 'p.moo', 'p.vill_name', 'ct.tambonname', 'cd.name_disease')
            ->leftJoin('cprenames as cp', 'cp.id_prename', '=', 'p.prename')
            ->leftJoin('ctambons as ct', 'ct.maptambon', '=', 'p.tambon')
            ->leftJoin('cdiseases as cd', 'cd.id_disease', '=', 'p.first_sick')
            ->leftJoin('chospital_amp as ch', 'ch.hoscode', '=', 'p.hospcode')
            ->orderBy('p.created_at', 'DESC')
            ->paginate(10);

        $res = [
            'pagination' => [
                'total' => $p->total(),
                'per_page' => $p->perPage(),
                'current_page' => $p->currentPage(),
                'last_page' => $p->lastPage(),
                'from' => $p->firstItem(),
                'to' => $p->lastItem()
            ],
            'rawData' => $p
        ];
        return response()->json($res);
    }

    public function getPatientByIdNo(Request $req){
        $id_no = $req->getContent();
        //dd($id_no);
        $p = DB::table('patients as p')
            ->select('p.id_no', 'p.hospcode', 'ch.hosname', 'p.hn', 'cp.detail', 'p.name', 'p.lname', 'p.birth', DB::raw('TIMESTAMPDIFF(YEAR,p.birth,NOW()) as ages'), 'cn.nationname', 'ce.educationname', 'co.occupationname', 'p.add_no', 'p.moo', 'p.vill_name', 'ct.tambonname', 'cd.name_disease')
            ->leftJoin('cprenames as cp', 'cp.id_prename', '=', 'p.prename')
            ->leftJoin('ctambons as ct', 'ct.maptambon', '=', 'p.tambon')
            ->leftJoin('cdiseases as cd', 'cd.id_disease', '=', 'p.first_sick')
            ->leftJoin('chospital_amp as ch', 'ch.hoscode', '=', 'p.hospcode')
            ->leftJoin('cnations as cn', 'cn.mapnation', '=', 'p.nation')
            ->leftJoin('ceducations as ce', 'ce.mapeducation', '=', 'p.education')
            ->leftJoin('coccupations as co', 'co.mapoccupation', '=', 'p.occupation')
            ->orderBy('p.hn', 'ASC')
            ->where('p.id_no', '=', $id_no)
            ->get();

        $res = [
            'rawData' => $p
        ];
        return response()->json($res);
    }

    public function getPatientByFullName(Request $request)
    {
        $fname = $request['fName'];
        $lname = $request['lName'];

        $p = DB::table('patients as p')
        ->select('p.id_no', 'p.hospcode', 'ch.hosname', 'p.hn', 'cp.detail', 'p.name', 'p.lname', 'p.birth', 'p.add_no', 'p.moo', 'p.vill_name', 'ct.tambonname', 'cd.name_disease')
        ->leftJoin('cprenames as cp', 'cp.id_prename', '=', 'p.prename')
        ->leftJoin('ctambons as ct', 'ct.maptambon', '=', 'p.tambon')
        ->leftJoin('cdiseases as cd', 'cd.id_disease', '=', 'p.first_sick')
        ->leftJoin('chospital_amp as ch', 'ch.hoscode', '=', 'p.hospcode')
        ->where('p.name', 'like', '%' . $fname . '%')
        ->where('p.lname', 'like', '%' . $lname . '%')
        ->orderBy('p.created_at', 'DESC')
        ->paginate(10);

        $res = [
            'pagination' => [
                'total' => $p->total(),
                'per_page' => $p->perPage(),
                'current_page' => $p->currentPage(),
                'last_page' => $p->lastPage(),
                'from' => $p->firstItem(),
                'to' => $p->lastItem()
            ],
            'rawData' => $p
        ];

        return response()->json($res);
    }
    
    public function getPatientByHosId(Request $request)
    {
        $hid = $request->getContent();
        if(!empty($hid)){
            $p = DB::table('patients as p')
            ->select('p.id_no', 'p.hospcode', 'ch.hosname', 'p.hn', 'cp.detail', 'p.name', 'p.lname', 'p.birth', 'p.add_no', 'p.moo', 'p.vill_name', 'ct.tambonname', 'cd.name_disease')
            ->leftJoin('cprenames as cp', 'cp.id_prename', '=', 'p.prename')
            ->leftJoin('ctambons as ct', 'ct.maptambon', '=', 'p.tambon')
            ->leftJoin('cdiseases as cd', 'cd.id_disease', '=', 'p.first_sick')
            ->leftJoin('chospital_amp as ch', 'ch.hoscode', '=', 'p.hospcode')
            ->where('p.hospcode', '=', $hid)
            ->orderBy('p.created_at', 'DESC')
            ->paginate(10);
        }else{
            $p = DB::table('patients as p')
            ->select('p.id_no', 'p.hospcode', 'ch.hosname', 'p.hn', 'cp.detail', 'p.name', 'p.lname', 'p.birth', 'p.add_no', 'p.moo', 'p.vill_name', 'ct.tambonname', 'cd.name_disease')
            ->leftJoin('cprenames as cp', 'cp.id_prename', '=', 'p.prename')
            ->leftJoin('ctambons as ct', 'ct.maptambon', '=', 'p.tambon')
            ->leftJoin('cdiseases as cd', 'cd.id_disease', '=', 'p.first_sick')
            ->leftJoin('chospital_amp as ch', 'ch.hoscode', '=', 'p.hospcode')
            ->orderBy('p.created_at', 'DESC')
            ->paginate(10);
        }
        

        $res = [
            'pagination' => [
                'total' => $p->total(),
                'per_page' => $p->perPage(),
                'current_page' => $p->currentPage(),
                'last_page' => $p->lastPage(),
                'from' => $p->firstItem(),
                'to' => $p->lastItem()
            ],
            'rawData' => $p
        ];

        return response()->json($res);
    }

    public function getAppointment(Request $request) 
    {
        $id = $request->getContent();

        $p = DB::table('appointments as a')
            ->select('a.id_no', 'a.app_hos', 'a.app_date', 'a.app_detail', 'a.doctor_id', 'a.others', 'a.app_status', 'ch.hosname', 'd.name_doctor')
            ->leftJoin('chospital_ref as ch', 'ch.hoscode', '=', 'a.app_hos')
            ->leftJoin('doctors as d', 'd.id_doctor', '=', 'a.doctor_id')
            ->where('a.id_no', '=', $id)
            ->orderBy('a.created_at', 'DESC')
            ->limit(3)
            ->get();

        $res = [
            'rawData' => $p
        ];
        return response()->json($res);
    }
}