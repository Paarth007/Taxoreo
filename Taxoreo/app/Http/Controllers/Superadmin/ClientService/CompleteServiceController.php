<?php
namespace App\Http\Controllers\Superadmin\ClientService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\General;
use Datatables;
use Session;
use DB;
use Facade\FlareClient\View;

class CompleteServiceController extends Controller
{
    private $url="superadmin/client-service/complete";

    public function index(){
        return view('Superadmin.ClientServices.CompleteServices.Index')->with(['url'=>$this->url]);
    }

    public function create(Request $request){

    }

    public function edit(Request $request,$id)
    {
        $user_service=General::get_user_service_details($id);
        $client_detail=General::get_client_details($id);
        $documents=General::get_documents($id);
        $comments=General::get_comments($id);
        $freelancers=General::get_freelancers($id);
        $payment_details=General::get_user_payment_details($id);

        return view('Superadmin.ClientServices.SharedComponent.ClientServiceDetails')
                ->with(['id'=>$id,
                        'url'=>$this->url,
                        'user_service'=>$user_service,
                        'client_detail'=>$client_detail,
                        'documents'=>$documents,
                        'comments'=>$comments,
                        'freelancers'=>$freelancers,
                        'payment_details'=>$payment_details
                    ]);
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {
        $data['is_work_verified']=$request->is_work_verified;
        $data['work_verified_at']=NULL;
        if($request->is_work_verified==1){
            $data['work_verified_at']=now();
        }
        DB::table('user_added_services')->where('id',$id)->update($data);

        $request->session()->flash('alert-success', 'Work Status Updated !!! ');
        return redirect()->back();
    }

    public function destroy(Request $request,$id)
    {
        // $is_destroyed=DB::table('users')->where('user_type','FREELANCER')->where('id',$id)->update(['is_active'=>0,'updated_at'=>NOW()]);
        // if($is_destroyed > 0){
        //     $request->session()->flash('alert-success', 'Freelancer deleted !!! ');
        // }else{
        //     $request->session()->flash('alert-warning', 'Freelancer not deleted !!! ');
        // }
        return redirect()->back();
    }

    public function show(Request $request)
    {
        $query = DB::table('user_added_services as us')
                        ->leftJoin('users as u','u.id','=','us.user_id')
                        ->leftJoin('users as asg','asg.id','=','us.assigned_to_user_id')
                        ->leftJoin('master_services as m','m.id','=','us.master_service_id');

        $data=$query->select( 'us.service_no','us.master_service_id','us.current_stage','us.total_documents','us.uploaded_documents',
                              'us.id','us.created_at','us.updated_at','us.assigned_to_user_id',
                              DB::RAW('CONCAT(u.first_name," ",u.last_name) as name'),
                              DB::RAW('CONCAT(asg.first_name," ",asg.last_name) as assign_to_user_name'),
                              'm.service_name','u.is_active','asg.is_active'
                            )
                        ->whereIn('us.current_stage',["WORK_IN_PROGRESS"])
                        ->where('us.current_status',"COMPLETE")
                        ->orderby('u.id','desc')
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
