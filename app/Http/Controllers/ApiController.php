<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 
use Intervention\Image\ImageManagerStatic as Image;

class ApiController extends Controller
{
    public function saveImage(Request $request){

        $id_no = $request['id_no'];
        $image_data = $request['img_patient'];
        
        $imageData = $image_data;
        $fileName = Carbon::now()->timestamp . '_' . uniqid() . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
        Image::make($image_data)->save(public_path('/images/').$fileName);

        if(DB::table('patients')->where('id_no', $id_no)->update(['img_name' => $fileName])){
            return 1;
        }else{
            return 0;
        }

        // $extension = $request['img_patient']->getClientOriginalExtension();
        
        // $filename = str_random(5);
        // $image = $filename.'.'.$extension;
        // Storage::disk('local')->put($image, File::get($request['img_patient']));
        // $request['img_patient']->move(public_path().'/images/', $image);
        // Storage::delete($image);
        // $request['img_patient'] = public_path().'/images/'.$image;

        // if(DB::table('patients')->where('id_no', $id_no)->update(['img_name' => $image])){
        //     return 1;
        // }else{
        //     return 0;
        // }
    }

    public function getAllPatient(Request $req){
        $p = DB::table('patients as p')
            ->select('p.id_no', 'p.hospcode', 'ch.hosname', 'p.hn', 'cp.detail', 'p.name', 'p.lname', 'p.birth', 'p.add_no', 'p.moo', 'p.vill_name', 'p.img_name', 'p.user_created', 'p.color_code', 'ct.tambonname', 'cd.name_disease')
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
            ->select('p.id_no', 'p.hospcode', 'ch.hosname', 'p.hn', 'p.prename', 'p.nation', 'p.race', 'cp.detail', 'p.img_name', 'p.name', 'p.lname', 'p.birth', 'p.sex','p.mstatus', 'p.education', 'p.occupation', 'p.religion', DB::raw('TIMESTAMPDIFF(YEAR,p.birth,NOW()) as ages'), 'cn.nationname', 'ce.educationname', 'co.occupationname', 'p.first_sick', 'p.recieve_date', 'p.add_no', 'p.moo', 'p.vill_name', 'p.user_created', 'p.tambon', 'p.ampur', 'p.changwat', 'p.color_code', 'ct.tambonname', 'cd.name_disease')
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
            ->select('a.id','a.id_no', 'a.app_hos', 'a.app_date', 'a.app_detail', 'a.doctor_id', 'a.others', 'a.app_status', 'ch.hosname', 'd.name_doctor')
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