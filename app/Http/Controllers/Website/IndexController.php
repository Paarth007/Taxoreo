<?php
namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;
use Validator;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories=DB::table('master_categories')->pluck('category_name','id')->toArray();
        $data=[];
        $max_row=0;
        foreach($categories as $id=>$name){
            $temp=[];
            $services=DB::table('master_services')
                        ->where('master_category_id',$id)
                        ->get()
                        ->toArray();
            foreach($services as $s){
                $temp[]=['id'=>$s->id,
                         'name'=>$s->service_name,
                        'actual_amount'=>$s->actual_amount,
                        'display_amount'=>$s->display_amount
                        ];
            }
            $data[$id]=["name"=>$name,'services'=>$temp];
            if($max_row < count($temp)){
                $max_row=count($temp);
            }
        }
        $sessionId = session()->getId();
        return view('Website.Index',compact('sessionId','categories','data','max_row'));
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
