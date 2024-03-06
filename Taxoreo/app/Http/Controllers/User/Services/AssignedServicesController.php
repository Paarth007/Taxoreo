<?php
namespace App\Http\Controllers\User\Services;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\General;
use Datatables;
use Session;
use DB;

class AssignedServicesController extends Controller
{
    public $url="user/services/assigned-services";
    private $doc_url="superadmin/service-list/client-added-services/document-status-update";

    public function index(){
        return view('User.Services.AssignedServices.Index')->with(['url'=>$this->url]);
    }

    public function create(){
        return view('User.Services.AssignedServices.Form')->with(['id'=>NULL,
                                                                  'url'=>$this->url,
                                                                  'services'=>NULL
                                                        ]);
    }

    public function edit($id){
        $user_service=General::get_user_service_details($id);
        $client_detail=General::get_client_details($id);
        $documents=General::get_documents($id);
        $comments=General::get_comments($id);

        return view('User.Services.AssignedServices.Form')->with(['id'=>$id,
                                                            'url'=>$this->url,
                                                            'doc_url'=>$this->doc_url,
                                                            'user_service'=>$user_service,
                                                            'client_detail'=>$client_detail,
                                                            'documents'=>$documents,
                                                            'comments'=>$comments
                                                        ]);
    }

    public function store(Request $request){

    }

    public function update(Request $request,$id)
    {
        //$prevData=DB::table('user_added_services')->where('id',$id)->first();

        if($request->old_status!=$request->current_status)
        {
            $is_updated=DB::table('user_added_services')->where('id',$id)
                                    ->update([
                                        'current_status'=>$request->current_status,
                                        'status_changed_at'=>now()
                                    ]);
            if($is_updated > 0)
            {
                Session::flash('alert-success', 'Status Updated Successfully !!!');
                return redirect($this->url);
            }else{
                Session::flash('alert-danger', 'Status Not Updated !!!');
                return redirect("$this->url/$id/edit");
            }
        }

        Session::flash('alert-warning', 'Nothing Updated !!!');
        return redirect("$this->url");
    }

    public function destroy($id)
    {

    }

    public function show(Request $request)
    {
        $query = DB::table('user_added_services as uas')
                    ->leftJoin('master_services as m','m.id','uas.master_service_id')
                    ->where('uas.assigned_to_user_id',Session::get('user_id'));

        $data = $query->select('uas.*','m.service_name')
                        ->orderby('uas.id','desc')
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
