<?php
namespace App\Http\Controllers\Website\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Validator;
use App\General;

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
                General::add_user_added_service($user->id,$user->company_type_id);
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



   

}
