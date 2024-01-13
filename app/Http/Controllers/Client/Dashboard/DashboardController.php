<?php
namespace App\Http\Controllers\Client\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use Redirect;
use DB;

class DashboardController extends Controller
{

    public function add_user_added_service(Request $request)
    {
        $master_service_id=[1];
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
         //   dd($total_documents);
            $master_service= DB::table('master_services')->where('id',$m)->first();

            $user_added_service_id=DB::table('user_added_services')
                    ->insertGetId([
                        'service_no'=>"T-90",
                        'user_id'=>Session::get('user_id'),
                        'master_service_id'=>$m,
                        'total_documents'=>count($total_documents),
                        'remaining_documents'=>count($total_documents),
                        'actual_amount'=>$master_service->actual_amount
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
        $request->session()->flash('alert-success', 'Temp Added Successfully !!! ');
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $new_services=$this->new_services();
        //dd($new_services);
        $current_services=$this->current_services();

        return view('Client.Dashboard.Index',compact('new_services','current_services'));
    }

    public function new_services(){
        $services=DB::table('user_added_services as us')
                    ->leftJoin('master_services as ms','ms.id','=','us.master_service_id')
                    ->where('us.user_id',Session::get('user_id'))
                    ->select('us.*','ms.service_name',
                            DB::RAW('(select count(*) from user_added_service_documents where user_added_service_id=us.id and document_status is not null) as documents_uploaded')
                    )
                    ->get();

        foreach($services as $cs){
            $query="SELECT msd.master_service_id,msd.master_document_id,md.id AS doc_id,md.document_name,
                usd.id as uploaded_document_id,
                usd.document_name AS uploaded_document_name,
                usd.document_path as uploaded_document_path,
                usd.document_status as uploaded_document_status
                FROM master_services_documents AS msd
                LEFT JOIN master_documents AS md ON md.id=msd.master_document_id
                LEFT JOIN user_added_service_documents AS usd ON (usd.master_document_id=msd.master_document_id AND usd.user_added_service_id=".$cs->id.")
                WHERE msd.master_service_id=".$cs->master_service_id." AND msd.master_company_type_id=1
                AND msd.is_active=1
                ORDER BY msd.master_document_id";
            $data=DB::SELECT(DB::RAW($query));
            $cs->documents=$data;
        }
        return $services;
    }

    public function current_services(){
        $services=DB::table('user_services as us')
                ->leftJoin('master_services as ms','ms.id','=','us.master_service_id')
                ->leftJoin('users as u','u.id','=','us.assign_to')
                ->where('us.user_id',Session::get('user_id'))
                ->select('us.*','ms.service_name',DB::RAW('CONCAT(u.first_name," ",u.last_name) as assign_to_user_name'),
                DB::RAW('(select count(*) from user_service_documents where user_service_id=us.id and document_status is not null) as documents_uploaded')
                )
                ->get();

        foreach($services as $cs){
            $query="SELECT msd.master_service_id,msd.master_document_id,md.id AS doc_id,md.document_name,
            usd.id as uploaded_document_id,usd.document_name AS uploaded_document_name
            FROM master_services_documents AS msd
            LEFT JOIN master_documents AS md ON md.id=msd.master_document_id
            LEFT JOIN user_service_documents AS usd ON (usd.master_document_id=msd.master_document_id AND usd.user_service_id=".$cs->id.")
            WHERE msd.master_service_id=".$cs->master_service_id." AND msd.master_company_type_id=1
            ORDER BY msd.master_document_id";
            $data=DB::SELECT(DB::RAW($query));
            $cs->documents=$data;
        }
        return $services;
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
        $data=$request->toArray();

        foreach($data['document_id'] as $key=>$doc_id)
        {
            if(array_key_exists($key,$data['upload_box']) && $data['upload_box'][$key])
            {
                $attachment=$data['upload_box'][$key];
                $attachment_name=$attachment->getClientOriginalName();
                $document_extension=$attachment->getClientOriginalExtension();
                $document_path='client/'.Session::get('user_id').'/'.$data['service_no'].'/';

                $attachment_name=str_replace(" ","_",str_replace("-"," ",$attachment_name));

                if($attachment->move($document_path,$attachment_name))
                {
                    DB::table("user_added_service_documents")
                            ->where('id',$doc_id)
                            ->update([
                                'document_extension'=>$document_extension,
                                'document_path'=>$document_path.$attachment_name,
                                'document_status'=>NULL,
                                'document_note'=>NULL
                            ]);
                }
            }
        }

        $remaining_documents=DB::table('user_added_service_documents')
                                    ->where('user_added_service_id',$request->service_id)
                                    ->whereNotNull('document_path')->count();

        $uploaded_documents=DB::table('user_added_service_documents')
                                ->where('user_added_service_id',$request->service_id)
                                ->whereNull('document_path')->count();

        DB::table('user_added_services')->where('id',$request->service_id)
                ->update([
                        'remaining_documents'=>$remaining_documents,
                        'uploaded_documents'=>$uploaded_documents,
                        ]);


        $request->session()->flash('alert-success', 'Document Added Successfully !!! ');
        return redirect()->back();
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
