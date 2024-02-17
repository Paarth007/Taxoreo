<?php
namespace App\Http\Controllers\superadmin\Master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;

class CompanyTypeController extends Controller
{
    public $url="superadmin/master/company-type";

    public function index(){
        return view('Superadmin.Master.CompanyType.Index')->with(['url'=>$this->url]);
    }

    public function create(){
        return view('Superadmin.Master.CompanyType.Form')->with(['id'=>NULL,
                                                            'url'=>$this->url,
                                                            'company_type'=>NULL
                                                        ]);
    }

    public function edit($id){
        $company_type=DB::table('master_company_types')->where('id',$id)->first();

        return view('Superadmin.Master.CompanyType.Form')->with(['id'=>$id,
                                                            'url'=>$this->url,
                                                            'company_type'=>$company_type
                                                        ]);
    }

    public function store(Request $request){
        $check=DB::table('master_company_types')->where('company_type_name',$request->company_type_name)->first();
        if($check){
            Session::flash('alert-danger', 'Company Type Already Exists !!!');
            return redirect($this->url."/create");
        }
        $id=DB::table('master_company_types')->insertGetId([
                                                    'company_type_name'=>$request->company_type_name,
                                                    'is_active'=>$request->is_active,
                                                    'remark'=>$request->remark ? $request->remark : NULL,
                                                    'created_at'=>now()
                                                ]);

        if($id > 0)
        {
            Session::flash('alert-success', 'Company Type Added Successfully !!!');
            if($request->button_type && $request->button_type=="SAVE_AND_ADD_ANOTHER"){
                return redirect($this->url."/create");
            }
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Company Type Not Added !!!');
            return redirect($this->url."/create");
        }
    }

    public function update(Request $request,$id)
    {
        $is_updated=DB::table('master_company_types')->where('id',$id)
                                        ->update([
                                            'company_type_name'=>$request->company_type_name,
                                            'is_active'=>$request->is_active,
                                            'remark'=>$request->remark ? $request->remark : NULL,
                                            'updated_at'=>now()
                                        ]);

        if($is_updated > 0){
            Session::flash('alert-success', 'Company Type Updated Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Company Type Not Updated !!!');
            return redirect("$this->url/$id/edit");
        }
    }

    public function destroy($id)
    {
        $is_destroyed=DB::table('master_company_types')->where('id',$id)->update([
                                                                    'is_active'=>0,
                                                                    'updated_at'=>now()
                                                                    ]);
        if($is_destroyed > 0){
            Session::flash('alert-success', 'Company Type Deleted Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Company Type Not Deleted !!!');
            return redirect("$this->url/$id/edit");
        }
    }

    public function show(Request $request)
    {
        $query = DB::table('master_company_types as s');

        if(isset($_GET["search_by_company_type"]) && $_GET["search_by_company_type"]){
            $query->where('s.category_name',$_GET["search_by_company_type"]);
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
