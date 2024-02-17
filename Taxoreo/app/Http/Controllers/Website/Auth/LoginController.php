<?php
namespace App\Http\Controllers\Website\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Validator;
use App\Helpers\General;
class LoginController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

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
        $username=$request->username;
        $check=DB::table('users')->where(function($q) use ($username){
                                        $q->where('email',$username)
                                          ->orWhere('mobile_no',$username);
                                    })
                                    ->first();
        if(!$check){
            return redirect()->back()->with('alert-danger','Account does not exists');
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
