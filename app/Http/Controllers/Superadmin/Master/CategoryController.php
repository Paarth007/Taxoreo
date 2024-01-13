<?php
namespace App\Http\Controllers\superadmin\Master;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;

class CategoryController extends Controller
{
    public $url="superadmin/master/category";

    public function index(){
        return view('Superadmin.Master.Category.Index')->with(['url'=>$this->url]);
    }

    public function create(){
        return view('Superadmin.Master.Category.Form')->with(['id'=>NULL,
                                                            'url'=>$this->url,
                                                            'category'=>NULL
                                                        ]);
    }

    public function edit($id){
        $category=DB::table('master_categories')->where('id',$id)->first();

        return view('Superadmin.Master.Category.Form')->with(['id'=>$id,
                                                            'url'=>$this->url,
                                                            'category'=>$category
                                                        ]);
    }

    public function store(Request $request){
        $check=DB::table('master_categories')->where('category_name',$request->category_name)->first();
        if($check){
            Session::flash('alert-danger', 'Category Already Exists !!!');
            return redirect($this->url."/create");
        }
        $id=DB::table('master_categories')->insertGetId([
                                                    'category_name'=>$request->category_name,
                                                    'is_active'=>$request->is_active,
                                                    'remark'=>$request->remark ? $request->remark : NULL,
                                                    'created_at'=>now()
                                                ]);

        if($id > 0)
        {
            Session::flash('alert-success', 'Category Added Successfully !!!');
            if($request->button_type && $request->button_type=="SAVE_AND_ADD_ANOTHER"){
                return redirect($this->url."/create");
            }
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Category Not Added !!!');
            return redirect($this->url."/create");
        }
    }

    public function update(Request $request,$id)
    {
        $is_updated=DB::table('master_categories')->where('id',$id)
                                        ->update([
                                            'category_name'=>$request->category_name,
                                            'is_active'=>$request->is_active,
                                            'remark'=>$request->remark ? $request->remark : NULL,
                                            'updated_at'=>now()
                                        ]);

        if($is_updated > 0)
        {
            Session::flash('alert-success', 'Category Updated Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Category Not Updated !!!');
            return redirect("$this->url/$id/edit");
        }
    }

    public function destroy($id)
    {
        $is_destroyed=DB::table('master_categories')->where('id',$id)->update([
                                                                    'is_active'=>0,
                                                                    'updated_at'=>now()
                                                                    ]);
        if($is_destroyed > 0){
            Session::flash('alert-success', 'Category Deleted Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Category Not Deleted !!!');
            return redirect("$this->url/$id/edit");
        }
    }

    public function show(Request $request)
    {
        $query = DB::table('master_categories as s');

        if(isset($_GET["search_by_category_name"]) && $_GET["search_by_category_name"]){
            $query->where('s.category_name',$_GET["search_by_category_name"]);
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
