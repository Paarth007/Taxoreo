<?php
namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Validator;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('User.Login');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $check=DB::table("users")->where('email',$request->email)->where('user_type','FREELANCER')->first();
        if($check)
        {
            Session::put('user_name',$check->first_name." ".$check->last_name);
            Session::put('user_id',$check->id);
            Session::put('user_type',$check->user_type);
            return redirect('user/dashboard');
        }else{
            Session::flash("alert-danger","Invalid Credentials !!!");
            return redirect()->back();
        }
    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        Session::flush();
        Session::flash("alert-success","Logout Successfully !!!");
        return redirect('superadmin/login');
    }
}
