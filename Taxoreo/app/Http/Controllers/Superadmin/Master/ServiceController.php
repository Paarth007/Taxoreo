<?php
namespace App\Http\Controllers\superadmin\Master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;

class ServiceController extends Controller
{
    public $url="superadmin/master/service";

    public function index(){
        return view('Superadmin.Master.Service.Index')->with(['url'=>$this->url]);
    }

    public function create(){
        $required_documents=DB::table('master_documents')->where('is_active',1)->get();
        $company_types=DB::table('master_company_types')->where('is_active',1)->get();

        return view('Superadmin.Master.Service.Form')->with(['id'=>NULL,
                                                            'url'=>$this->url,
                                                            'service'=>NULL,
                                                            'required_documents'=>$required_documents,
                                                            'company_types'=>$company_types,
                                                            'service_documents'=>NULL
                                                        ]);
    }

    public function edit($id){
        $service=DB::table('master_services')->where('id',$id)->first();
        $required_documents=DB::table('master_documents')->where('is_active',1)->get();
        $company_types=DB::table('master_company_types')->where('is_active',1)->get();

        $service_documents=[];
        foreach($company_types as $c){
            $c->documents=DB::table('master_services_documents')->where('master_service_id',$id)
                                                                            ->where('master_company_type_id',$c->id)
                                                                            ->where('is_active',1)
                                                                            ->pluck('master_document_id')
                                                                            ->toArray();
        }
        return view('Superadmin.Master.Service.Form')->with(['id'=>$id,
                                                            'url'=>$this->url,
                                                            'service'=>$service,
                                                            'required_documents'=>$required_documents,
                                                            'company_types'=>$company_types,
                                                            'service_documents'=>$service_documents
                                                        ]);
    }

    public function store(Request $request){
        $check=DB::table('master_services')->where('service_name',$request->service_name)->first();
        if($check){
            Session::flash('alert-danger', 'Service Already Exists !!!');
            return redirect($this->url."/create");
        }
        $id=DB::table('master_services')->insertGetId([
                                                    'service_name'=>$request->service_name,
                                                    'display_amount'=>$request->display_amount,
                                                    'actual_amount'=>$request->actual_amount,
                                                    'is_active'=>$request->is_active,
                                                    'remark'=>$request->remark ? $request->remark : NULL,
                                                    'created_at'=>now()
                                                ]);

        if($id > 0){

            $this->update_document_ids($request->master_document_id,$id);

            Session::flash('alert-success', 'Service Added Successfully !!!');
            if($request->button_type && $request->button_type=="SAVE_AND_ADD_ANOTHER"){
                return redirect($this->url."/create");
            }
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Service Not Added !!!');
            return redirect($this->url."/create");
        }
    }

    public function update(Request $request,$id)
    {
        $is_updated=DB::table('master_services')->where('id',$id)
                                        ->update([
                                            'service_name'=>$request->service_name,
                                            'display_amount'=>$request->display_amount,
                                            'actual_amount'=>$request->actual_amount,
                                            'is_active'=>$request->is_active,
                                            'remark'=>$request->remark ? $request->remark : NULL,
                                            'updated_at'=>now()
                                        ]);

        if($is_updated > 0)
        {
            $this->update_document_ids($request->master_document_id,$id);
            Session::flash('alert-success', 'Service Updated Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Service Not Updated !!!');
            return redirect("$this->url/$id/edit");
        }
    }

    public function update_document_ids($master_document_id,$master_service_id)
    {
        foreach($master_document_id as $company_type_id=>$documents_ids){
                DB::table('master_services_documents')
                        ->where([
                                'master_service_id'=>$master_service_id,
                                'master_company_type_id'=>$company_type_id,
                                'is_active'=>1])
                        ->update(['is_active'=>0,
                                'updated_at'=>now()]);
           $temp=[];
            foreach($documents_ids as $document_id)
            {
                $x=[];
                $x['id']=$document_id;
                $check=DB::table('master_services_documents')
                                ->where([
                                    'master_service_id'=>$master_service_id,
                                    'master_company_type_id'=>$company_type_id,
                                    'master_document_id'=>$document_id,
                                ])->first();
                $x['check']=$check;
                if($check){
                    DB::table('master_services_documents')
                            ->where('id',$check->id)
                            ->update(['is_active'=>1,'updated_at'=>now()]);

                }else{
                    DB::table('master_services_documents')->insert([
                        'master_service_id'=>$master_service_id,
                        'master_company_type_id'=>$company_type_id,
                        'master_document_id'=>$document_id,
                        'created_at'=>now()
                        ]);
                }
                $temp[]=$x;
            }
        }
    }
    public function destroy($id)
    {
        $is_destroyed=DB::table('master_services')->where('id',$id)->update([
                                                                    'is_active'=>0,
                                                                    'updated_at'=>now()
                                                                    ]);
        if($is_destroyed > 0){
            Session::flash('alert-success', 'Service Deleted Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Service Not Deleted !!!');
            return redirect("$this->url/$id/edit");
        }
    }

    public function show(Request $request)
    {
        $query = DB::table('master_services as s');

        if(isset($_GET["search_by_service_name"]) && $_GET["search_by_service_name"]){
            $query->where('s.service_name',$_GET["search_by_service_name"]);
        }

        $data = $query->select('s.*')
                        ->orderby('s.id','desc')
                        ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('select_checkbox', function($row){
                return '<input type="checkbox" class="select_all_individual_checkbox" name="id[]" value="'.$row->id.'">';
            })
            ->addColumn('is_active', function($row){
                return $row->is_active==1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Deactive</span>';
            })
            ->addColumn('action',function($row){
                $ret='<a href="'.url($this->url.'/'.$row->id.'/edit').'"
                        class="btn btn-icon btn-2 btn-sm btn-success px-1 py-0">
                            <i class="fas fa-pencil-alt"></i>
                        </a>';
                return $ret;
                })
            ->rawColumns(['select_checkbox','is_active','action'])
            ->make(true);
    }

}
