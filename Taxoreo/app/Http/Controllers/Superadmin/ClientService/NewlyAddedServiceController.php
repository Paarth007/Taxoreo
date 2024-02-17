<?php
namespace App\Http\Controllers\Superadmin\ClientService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;
use Facade\FlareClient\View;

class NewlyAddedServiceController extends Controller
{
    private $url="superadmin/client-service/newly-added-services";
    private $doc_url="superadmin/client-service/newly-added-services/document-status-update";

    public function index(){
        return view('Superadmin.ClientServices.NewlyAdded.Index')->with(['url'=>$this->url]);
    }

    public function create(Request $request){
        return view('superadmin.ClientServices.NewlyAdded.Form')->with(['id'=>NULL,'url'=>$this->url,'document'=>NULL]);
    }

    public function edit(Request $request,$id){

        $user_service=DB::table('user_added_services as us')
                            ->leftJoin('master_services as ms','ms.id','us.master_service_id')
                            ->where('us.id',$id)
                            ->select('us.*','ms.service_name')
                            ->first();
        $user_documents=DB::table('user_added_service_documents')
                            ->where('user_added_service_id',$id)->get();

        return view('superadmin.ClientServices.NewlyAdded.Form')->with(['id'=>$id,
                                                                        'url'=>$this->url,
                                                                        'doc_url'=>$this->doc_url,
                                                                        'user_service'=>$user_service,
                                                                        'user_documents'=>$user_documents
                                                                    ]);
    }

    public function store(Request $request)
    {

    }

    public function update(Request $request, $id)
    {
        $data['payment_type']=$request->payment_type;
        $data['total_advance_amount']=$request->payment_type=="ADVANCE_PAYMENT" ? $request->total_advance_amount : 0;

        $paymentDetails=[];
        if($request->payment_type=="ADVANCE_PAYMENT"){
            $payment=[];
            $payment['user_added_service_id']=$id;
            $payment['payment_type']="ADVANCE_PAYMENT";
            $payment['payable_amount']=$request->total_advance_amount;
            $payment['created_at']=NOW();
            $paymentDetails[]=$payment;

            $payment=[];
            $payment['user_added_service_id']=$id;
            $payment['payment_type']="FINAL_PAYMENT";
            $payment['payable_amount']=$request->total_amount-$request->total_advance_amount;
            $payment['created_at']=NOW();
            $paymentDetails[]=$payment;
        }else{
            $payment=[];
            $payment['user_added_service_id']=$id;
            $payment['payment_type']="FULL_PAYMENT";
            $payment['payable_amount']=$request->total_amount;
            $payment['created_at']=NOW();
            $paymentDetails[]=$payment;
        }

        DB::table('user_added_services')->where('id',$id)->update($data);

        DB::table('user_added_service_payments')->insert($paymentDetails);

        $request->session()->flash('alert-success', 'Payment Details Updated !!! ');
        return redirect()->back();
    }

    public function destroy(Request $request,$id)
    {
        $is_destroyed=DB::table('users')->where('user_type','FREELANCER')->where('id',$id)->update(['is_active'=>0,'updated_at'=>NOW()]);
        if($is_destroyed > 0){
            $request->session()->flash('alert-success', 'Freelancer deleted !!! ');
        }else{
            $request->session()->flash('alert-warning', 'Freelancer not deleted !!! ');
        }
        return redirect()->back();
    }

    public function show(Request $request)
    {
        $query = DB::table('user_added_services as us')
                ->leftJoin('users as u','u.id','=','us.user_id')
                ->leftJoin('master_services as m','m.id','=','us.master_service_id');

        $data=$query->select( 'us.service_no','us.master_service_id','us.current_stage','us.total_documents','us.uploaded_documents',
                              'us.id',DB::RAW('CONCAT(u.first_name," ",u.last_name) as name'),'m.service_name',
                              'u.is_active','us.created_at','us.updated_at'
                            )
                ->whereIn('current_stage',["DOCUMENT","PAYMENT"])
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

    public function documentStatusUpdate(Request $request,$id){

        foreach($request->document_status as $doc_id=>$value){
            $data=[];
            $data['document_status']=$value;
            if($value=="REJECTED"){
                $data['document_path']=NULL;
            }
            $data['document_note']=array_key_exists($doc_id,$request->document_note) ? $request->document_note[$doc_id] : NULL;
            $data['updated_at']=now();

            DB::table('user_added_service_documents')
                        ->where('id',$doc_id)
                        ->update($data);
        }

        $documents=DB::table('user_added_service_documents')->where('user_added_service_id',$id)->get();
        $uploaded_documents=0;
        $remaining_documents=0;
        $all_document_verified=1;

        foreach($documents as $d){
            if($d->document_path){
                $uploaded_documents++;
            }else{
                $remaining_documents++;
            }

            if($d->document_status=="REJECTED" && $all_document_verified==1){
                $all_document_verified=0;
            }
        }

        $updating_fileds['remaining_documents']=$remaining_documents;
        $updating_fileds['uploaded_documents']=$uploaded_documents;
        $updating_fileds['all_document_verified']=$all_document_verified;
        if($all_document_verified==1){
            $updating_fileds['current_stage']="PAYMENT";
        }
        DB::table('user_added_services')->where('id',$id)->update($updating_fileds);

        if($all_document_verified==1){
            $request->session()->flash('alert-success', 'All document verified kindly update payment details !!! ');
        }else{
            $request->session()->flash('alert-success', 'Document Details Updated !!! ');
        }
        return redirect()->back();
    }

}
