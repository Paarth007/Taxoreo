<?php
namespace App\Http\Controllers\Superadmin\Report;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;

class PaymentLogController extends Controller
{
    public $url="superadmin/report/payment-log";

    public function index(Request $request)
    {
        return view('Superadmin.Report.PaymentLog.Index')->with(['url'=>$this->url]);
    }

    public function show()
    {
        $data = DB::table('payment_logs')
                        ->orderBy('id','DESC')
                        ->get();
        return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    return '<a href="'.url('superadmin/report/payment-details/'.$row->id).'" class="btn btn-primary btn-sm px-1 py-0"
                                title="Payment Details"
                                >
                                <i class="fas fa-share"></i>
                            </a>';
                })
                ->addColumn('select_checkbox', function($row){
                    return '<input type="checkbox" class="select_all_individual_checkbox" name="id[]" value="'.$row->id.'">';
                })
                ->rawColumns(['select_checkbox','is_active','action'])
                ->make(true);
    }


}
