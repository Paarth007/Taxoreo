<?php
namespace App\Http\Controllers\Superadmin\Auth;

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
        $years=DB::table('master_periods')
        ->whereYear('to_date','<=',(date('Y')+1))
        ->where('is_active',1)
        ->select('period_name','from_date','to_date',DB::raw('DATE_FORMAT(from_date, "%d-%b-%Y") as from_date_display'),
                DB::raw('DATE_FORMAT(to_date, "%d-%b-%Y") as to_date_display'))
        ->orderBy('id','desc')
        ->get();
        return view('Superadmin.Login',compact('years'));
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
            //General::set_financial_year($request->financial_year);
            Session::put('user_id',$check->id);
            return redirect('superadmin/dashboard');
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
