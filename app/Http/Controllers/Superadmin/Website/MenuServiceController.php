<?php
namespace App\Http\Controllers\Superadmin\Website;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;

class MenuServiceController extends Controller
{
    public $url="superadmin/website/menu-service";

    public function index(){
        return view('Superadmin.Website.MenuService.Index')->with(['url'=>$this->url]);
    }

    public function create(){
        return view('Superadmin.Website.MenuService.Form')->with(['id'=>NULL,
                                                            'url'=>$this->url,
                                                            'menu_service'=>NULL
                                                        ]);
    }

    public function edit($id){
        $menu_service=DB::table('website_menu_services')->where('id',$id)->first();
        return view('Superadmin.Website.MenuService.Form')->with(['id'=>$id,
                                                            'url'=>$this->url,
                                                            'menu_service'=>$menu_service,
                                                        ]);
    }

    public function store(Request $request){
        $check=DB::table('website_menu_services')->where('menu_service_name',$request->menu_service_name)->first();
        if($check){
            Session::flash('alert-danger', 'Menu Service Already Exists !!!');
            return redirect($this->url."/create");
        }
        $id=DB::table('website_menu_services')->insertGetId([
                                                    'menu_service_name'=>$request->menu_service_name,
                                                    'redirection_url'=>$request->redirection_url,
                                                    'is_active'=>$request->is_active,
                                                    'remark'=>$request->remark ? $request->remark : NULL,
                                                    'created_at'=>now()
                                                ]);

        if($id > 0)
        {
            Session::flash('alert-success', 'Menu Service Added Successfully !!!');
            if($request->button_type && $request->button_type=="SAVE_AND_ADD_ANOTHER"){
                return redirect($this->url."/create");
            }
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Menu Service Not Added !!!');
            return redirect($this->url."/create");
        }
    }

    public function update(Request $request,$id)
    {
        $is_updated=DB::table('website_menu_services')->where('id',$id)
                                        ->update([
                                            'menu_service_name'=>$request->menu_service_name,
                                            'redirection_url'=>$request->redirection_url,
                                            'is_active'=>$request->is_active,
                                            'remark'=>$request->remark ? $request->remark : NULL,
                                            'updated_at'=>now()
                                        ]);
        if($is_updated > 0)
        {
            Session::flash('alert-success', 'Menu Service Updated Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Menu Service Not Updated !!!');
            return redirect("$this->url/$id/edit");
        }
    }

    public function destroy($id)
    {
        $is_destroyed=DB::table('website_menu_services')->where('id',$id)->update([
                                                                    'is_active'=>0,
                                                                    'updated_at'=>now()
                                                                    ]);
        if($is_destroyed > 0){
            Session::flash('alert-success', 'Menu Service Deleted Successfully !!!');
            return redirect($this->url);
        }else{
            Session::flash('alert-danger', 'Menu Service Not Deleted !!!');
            return redirect("$this->url/$id/edit");
        }
    }

    public function show(Request $request)
    {
        $query = DB::table('website_menu_services as m');

        if(isset($_GET["search_by_menu_service_name"]) && $_GET["search_by_menu_service_name"]){
            $query->where('m.menu_service_name',$_GET["search_by_menu_service_name"]);
        }

        $data = $query->select('m.*')
                        ->orderby('m.id','desc')
                        ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('url', function($row){
                if($row->redirection_url){
                    if($row->redirection_url=="#"){
                        return "#";
                    }else{
                        return '<a href="'.$row->redirection_url.'" target="_blank"><span class="badge badge-warning">Open</span></a>';
                    }
                }
                return "";
            })
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
            ->rawColumns(['url','select_checkbox','is_active','action'])
            ->make(true);
    }

}
