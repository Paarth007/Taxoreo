<?php
namespace App\Http\Controllers\Website\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Validator;

class RegisterController extends Controller
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
        $company_types=DB::table('master_company_types')->where('is_active',1)->select('id','company_type_name')->get();
        return view('Website.Auth.Register',compact('data','company_types'));
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
        $check=DB::table('users')->where('email',$request->email)
                                 ->whereOr('mobie_no',$request->mobile_no)
                                 ->first();

        if($check){
            return redirect()->back()->with('alert-danger','Email or Mobile Number Already Exist');
        }
        $otp=rand(11111,999999);
        DB::table('users')
            ->insert([
                "user_type"=>"CLIENT",
                "compant_type_id"=>$request->company_type_id,
                "first_name"=>$request->first_name,
                "last_name"=>$request->last_name,
                "email"=>$request->email,
                "mobile_no"=>$request->mobile_no,
                "created_at"=>now(),
                //"otp"=>rand(11111,999999)
            ]);
        Session::put('is_new_user',1);
        Session::put('mobile_no',$request->mobile_no);
        Session::put('otp',$otp);
        return redirect('Auth/otp');
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
