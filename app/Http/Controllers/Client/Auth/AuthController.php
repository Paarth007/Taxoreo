<?php
namespace App\Http\Controllers\Client\Auth;

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
        return view('Client.Login');
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $check=DB::table("users")->where('email',$request->email)->first();
        if($check)
        {
            Session::put('user_id',$check->id);
            Session::put('user_type',$check->user_type);
            return redirect('client/dashboard');
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
