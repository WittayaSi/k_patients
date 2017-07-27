<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Chospital;
use App\Cdisease;
use App\Ceducation;
use App\Cmstatus;
use App\Cnation;
use App\Coccupation;
use App\Cprename;
use App\Creligion;
use App\Ctambon;
use App\Patient;
use App\Chospitalrefer;
use App\Doctor;
use App\Appointment;

class PatientController extends Controller
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
        $data['hospital'] = Chospital::select('hoscode', 'hosname')->get();
        $data['hos_ref'] = Chospitalrefer::all();
        $data['edu'] = Ceducation::all();
        $data['mstatus'] = Cmstatus::all();
        $data['nation'] = Cnation::all();
        $data['occup'] = Coccupation::all();
        $data['prename'] = Cprename::all();
        $data['religion'] = Creligion::all();
        $data['tambon'] = Ctambon::all();
        $data['disease'] = Cdisease::all();
        $data['doctor'] = Doctor::all();

        $data['hn_str'] = $this->newHn();

        return view('patients/index', $data);
    }

    private function newHn(){
        $hn_str = '';
        $d = DB::table('hn_ref')->select('last_hn')->first();
        $last_hn = $d->last_hn;
        $new_hn = (int)$last_hn + 1;

        if($new_hn < 10){
            $hn_str = 'KP000' . $new_hn;
        }else if($new_hn < 100){
            $hn_str = 'KP00' . $new_hn;
        }else if($new_hn < 1000){
            $hn_str = 'KP0' . $new_hn;
        }else{
            $hn_str = 'KP' . $new_hn;
        }

        return $hn_str;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //return view('patients/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        // $this->validate($request, [
        //     'pic_name' => 'image|mimes:jpeg,png,jpg',
        // ]);

        //$strRand = substr(md5(microtime()),rand(0,26),5);
        //$strRand = rand(10000,50000);
        //$imageName = $request['hospcode'].$strRand;

        $patient = new Patient();

        $patient->id_no = $request['idNo'];
        $patient->hospcode = $request['hospcode'];
        $patient->hn = $request['hn'];
        $patient->first_sick = $request['first_sick'];
        $patient->recieve_date = $request['recieve_date'];
        $patient->prename = $request['preName'];
        $patient->name = $request['fName'];
        $patient->lname = $request['lName'];
        $patient->birth = $request['dob'];
        $patient->sex = $request['sex'];
        $patient->race = $request['race'];
        $patient->nation = $request['nation'];
        $patient->mstatus = $request['mStatus'];
        $patient->education = $request['education'];
        $patient->occupation = $request['occupation'];
        $patient->religion = $request['religion'];
        $patient->add_no = $request['address_no'];
        $patient->moo = $request['moo'];
        $patient->vill_name = $request['village'];
        $patient->tambon = $request['tambon'];
        $patient->ampur = $request['ampur'];
        $patient->changwat = $request['changwat'];
        $patient->user_created = $request['userId'];

        $new_hn = (int)substr(($request['hn']),2);

        if(DB::table('hn_ref')->where('id', 1)->update(['last_hn' => $new_hn])){
            if($patient->save()){
                $hn_new = $this->newHn();
                $res = [
                    'success' => 'successfully',
                    'rawData' => $hn_new
                ];
                return response()->json($res);
            }else{
                return 'failed';
            }
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
        $patient = Patient::find($id);

        $patient->id_no = $request['idNo'];
        $patient->hospcode = $request['hospcode'];
        $patient->hn = $request['hn'];
        $patient->first_sick = $request['first_sick'];
        $patient->recieve_date = $request['recieve_date'];
        $patient->prename = $request['preName'];
        $patient->name = $request['fName'];
        $patient->lname = $request['lName'];
        $patient->birth = $request['dob'];
        $patient->sex = $request['sex'];
        $patient->race = $request['race'];
        $patient->nation = $request['nation'];
        $patient->mstatus = $request['mStatus'];
        $patient->education = $request['education'];
        $patient->occupation = $request['occupation'];
        $patient->religion = $request['religion'];
        $patient->add_no = $request['address_no'];
        $patient->moo = $request['moo'];
        $patient->vill_name = $request['village'];
        $patient->tambon = $request['tambon'];
        $patient->ampur = $request['ampur'];
        $patient->changwat = $request['changwat'];
        $patient->user_created = $request['userId'];

        
        if($patient->save()){
            $res = [
                'success' => 'successfully'
            ];
            return response()->json($res);
        }else{
            return 'failed';
        }
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
        if(Appointment::where('id_no', '=', $id)->delete()){
            Patient::destroy($id);
        }
    }
}
