<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Validator;

class ServiceOperationController extends Controller
{
    public function addService(Request $request)
    {
        if($request->ajax())
        {
            $check=DB::table('user_added_services_temp')
                                    ->where([
                                            "session_id"=>session()->getId(),
                                            "service_id"=>$request->service_id
                                            ])
                                            ->first();
            if(!$check){
                    DB::table('user_added_services_temp')
                        ->insert([
                                    "session_id"=>session()->getId(),
                                    "service_id"=>$request->service_id,
                                    "actual_amount"=>$request->actual_amount,
                                    'created_at'=>now()
                                ]);
            }
            $data=$this->getData();
            return response()->json(['status'=>1,'message'=>"",'data'=>$data]);
        }else{
            return response()->json(['status'=>0,'message'=>"Required Ajax Request",'data'=>NULL]);
        }
    }

    public function removeService(Request $request)
    {
        if($request->ajax()){
            DB::table('user_added_services_temp')
                ->where([
                        "session_id"=>session()->getId(),
                        "service_id"=>$request->service_id
                        ])
                ->delete();
            $data=$this->getData();
            return response()->json(['status'=>1,'message'=>"",'data'=>$data]);
        }else{
            return response()->json(['status'=>0,'message'=>"Required Ajax Request",'data'=>NULL]);
        }
    }

    public function getSelectedServices(Request $request)
    {
        $data=$this->getData();
        return response()->json(['status'=>1,'message'=>"",'data'=>$data]);
    }

    public function getData(){
        $data=DB::table('user_added_services_temp as u')
                ->leftJoin('master_services as m','m.id','u.service_id')
                ->where("u.session_id",session()->getId())
                ->select('m.id','m.service_name as name','u.actual_amount')
                ->get();
        return $data;
    }
}
