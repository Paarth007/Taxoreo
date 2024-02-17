<?php
namespace App\Http\Controllers\Client\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Validator;
use App\Helpers\General;

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
        if(!$check){
            Session::flash("alert-danger","Invalid Credentials !!!");
            return redirect()->back();
        }


       if($check->password!=$request->password){
            return redirect()->back()->with('alert-danger','Password doest not match');
        }

        General::add_user_added_service($check->id,$check->company_type_id);

        Session::put('user_name',$check->first_name." ".$check->last_name);
        Session::put('user_id',$check->id);
        Session::put('user_type',$check->user_type);
        Session::put('company_type_id',$check->company_type_id);
        return redirect('client/dashboard');
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
        return redirect('client/login');
    }
}
