<?php
namespace App\Http\Controllers\Superadmin\ClientService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;
use App\Helpers\General;

class PaymentVerificationAssignUserServiceController extends Controller
{
    private $url="superadmin/client-service/payment-verification-assign-user";
    private $doc_url="superadmin/client-service/payment-verification-assign-user/document-status-update";

    public function index(){
        return view('Superadmin.ClientServices.PaymentVerificationAssignUser.Index')->with(['url'=>$this->url]);
    }

    public function create(Request $request){
        return view('Superadmin.ClientServices.PaymentVerificationAssignUser.Form')->with(['id'=>NULL,'url'=>$this->url,'document'=>NULL]);
    }

    public function edit(Request $request,$id){

        $user_service=DB::table('user_added_services as us')
                            ->leftJoin('master_services as ms','ms.id','us.master_service_id')
                            ->leftJoin('users as c','c.id','us.user_id')
                            ->where('us.id',$id)
                            ->select('us.*','ms.service_name',
                                        DB::RAW('CONCAT(c.first_name," ",c.last_name) as client_name')
                                    )
                            ->first();

        $user_documents=DB::table('user_added_service_documents')
                            ->where('user_added_service_id',$id)
                            ->get();

        $payments=DB::table('user_added_service_payments as up')
                            ->leftJoin('payment_logs as p','p.id','up.payment_log_id')
                            ->where('up.user_added_service_id',$id)
                            ->select('up.*','p.easepayId as transaction_id','p.addedon')
                            ->get();

        $freelancers=DB::table('users')
                            ->select('id',DB::RAW('CONCAT(first_name," ",last_name) as freelancer_name'))
                            ->whereIn('user_type',['FREELANCER','ADMIN'])
                            ->where('is_active',1)
                            ->get();

        return view('Superadmin.ClientServices.PaymentVerificationAssignUser.Form')->with(['id'=>$id,
                            'url'=>$this->url,
                            'user_service'=>$user_service,
                            'user_documents'=>$user_documents,
                            'payments'=>$payments,
                            'freelancers'=>$freelancers
                        ]);

        // return view('Superadmin.ClientServices.SharedComponent.ClientServiceDetails')->with(['id'=>$id,
        //                                                                 'url'=>$this->url,
        //                                                                 'user_service'=>$user_service,
        //                                                                 'user_documents'=>$user_documents,
        //                                                                 'payments'=>$payments,
        //                                                                 'freelancers'=>$freelancers
        //                                                             ]);
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {
        $data=General::assign_user_to_service($id,$request->assigned_to_user_id);
        $data=General::convert_reponse_to_array($data);

        if($data['status']==1){
            $request->session()->flash('alert-success', 'Details Updated !!! ');
        }else{
            $request->session()->flash('alert-danger', $data['message']);
        }
        return redirect()->back();
    }

    public function changeUser(Request $request)
    {
        return General::assign_user_to_service($request->service_id,$request->user_id);
    }

    public function destroy(Request $request,$id)
    {
        // $is_destroyed=DB::table('users')->where('user_type','FREELANCER')->where('id',$id)->update(['is_active'=>0,'updated_at'=>NOW()]);
        // if($is_destroyed > 0){
        //     $request->session()->flash('alert-success', 'Freelancer deleted !!! ');
        // }else{
        //     $request->session()->flash('alert-warning', 'Freelancer not deleted !!! ');
        // }
        // return redirect()->back();
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
                    ->whereIn('current_stage',["WORK_IN_PROGRESS"])
                    ->whereNull('assigned_to_user_id')
                    ->orderby('u.id','desc')
                    ->get();

        $freelancers=DB::table('users')
                    ->select('id',DB::RAW('CONCAT(first_name," ",last_name) as freelancer_name'))
                    ->whereIn('user_type',['FREELANCER','ADMIN'])
                    ->where('is_active',1)
                    ->get();

        return Datatables::of($data)
            ->addIndexColumn()
            ->addColumn('select_checkbox', function($row){
                return '<input type="checkbox" class="select_all_individual_checkbox" name="id[]" value="'.$row->id.'">';
            })
            ->addColumn('is_active', function($row){
                return $row->is_active==1 ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Deactive</span>';
            })
            ->addColumn('assign_to_user_name', function($row) use ($freelancers){
               $render='<div class="form-group d-flex justify-content-between">
                            <input type="hidden" id="previous_assigned_user_id_'.$row->id.'" value="'.$row->assigned_to_user_id.'">
                            <select class="form-control form-control-sm"
                                        id="assigned_to_user_id_'.$row->id.'"
                                        >
                                <option value="">Select User</option>';
                                if(count($freelancers)){
                                    foreach($freelancers as $f){
                                        $selected="";
                                        if($row->assigned_to_user_id && $row->assigned_to_user_id==$f->id){
                                            $selected="selected";
                                        }
                                        $render.='<option value="'.$f->id.'" '.$selected.'>'.$f->freelancer_name.'</option>';
                                    }
                                }
                $render.='</select>
                            <button class="btn btn-sm btn-primary p-1"
                                    type="button"
                                onclick="change_user('.$row->id.')"
                            >
                                <i class="fas fa-exchange-alt"></i>
                            </button>
                        </div>';
                return $render;
            })
            ->addColumn('action',function($row){
                $ret='<a href="'.url($this->url.'/'.$row->id.'/edit').'"
                        class="btn btn-icon btn-2 btn-sm btn-success px-1 py-0">
                            <i class="fas fa-pencil-alt"></i>
                        </a>';
                return $ret;
            })
            ->rawColumns(['select_checkbox','is_active','action','assign_to_user_name'])
            ->make(true);
    }
}
