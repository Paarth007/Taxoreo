<?php
namespace App\Http\Controllers\Website\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Validator;

class OtpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sessionId = session()->getId();
        $data=NULL;
        $mobile_no=Session::get('mobile_no');
        $otp=Session::get('otp');
        return view('Website.Auth.Otp',compact('mobile_no','otp'));
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
        if($request->otp!=Session::get('otp')){
            Session::put('alert-danger',"Otp not match !!!");
            return redirect()->back();
        }

        $user=DB::table('users')->where('mobile_no',Session::get('mobile_no'))->first();
        if($user){
            DB::table('users')->where('id',$user->id)->update(['mobile_no_verified_at'=>now()]);

            Session::put('user_id',$user->id);
            Session::put('user_type',$user->user_type);

            if(Session::has('is_new_user') && Session::get('is_new_user')==1){
                $this->add_user_added_service();
            }
            return redirect('client/dashboard');
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



    public function add_user_added_service()
    {
        $master_service_id=DB::table('user_added_services_temp')
                ->whereDate('created_at',date('Y-m-d'))
                ->where('session_id',session()->getId())
                ->pluck('service_id')->toArray();

        if(count($master_service_id))
        {
            $master_service_id= array_unique($master_service_id);
            foreach($master_service_id as $m)
            {
                $company_type_id=1;
                $total_documents=DB::table('master_services_documents as m')
                                    ->leftJoin('master_documents as d','d.id','=','m.master_document_id')
                                    ->select('m.*','d.document_name')
                                    ->where('m.master_service_id',$m)
                                    ->where('m.master_company_type_id',$company_type_id)
                                    ->where('m.is_active',1)
                                    ->get();
                $master_service= DB::table('master_services')->where('id',$m)->first();

                $user_added_service_id=DB::table('user_added_services')
                        ->insertGetId([
                            'service_no'=>"T-90",
                            'user_id'=>Session::get('user_id'),
                            'master_service_id'=>$m,
                            'total_documents'=>count($total_documents),
                            'remaining_documents'=>count($total_documents),
                            'total_amount'=>$master_service->actual_amount
                        ]);

                foreach($total_documents as $t){
                    DB::table('user_added_service_documents')
                        ->insert([
                            'user_added_service_id'=>$user_added_service_id,
                            'user_id'=>Session::get('user_id'),
                            'master_document_id'=>$t->master_document_id,
                            'document_name'=>$t->document_name
                        ]);
                }
            }

            DB::table('user_added_services_temp')
                ->whereDate('created_at',date('Y-m-d'))
                ->where('session_id',session()->getId())
                ->delete();

        }
    }

}
