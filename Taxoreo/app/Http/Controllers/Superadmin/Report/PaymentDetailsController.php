<?php
namespace App\Http\Controllers\superadmin\Report;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Datatables;
use Session;
use DB;

class PaymentDetailsController extends Controller
{
    public $url="superadmin/report/payment-details";

    public function show(Request $request,$id)
    {
        $payment_details=DB::table('payment_logs')->where('id',$id)->first();
        return view('Superadmin.Report.PaymentDetails.Index')->with(['url'=>$this->url,'payment_details'=>$payment_details]);
    }


}
