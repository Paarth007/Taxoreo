<?php
namespace App\Http\Controllers\Client\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\Easebuzz;
use App\Helpers\Payment;
use Session;
use Redirect;
use DB;

class PaymentController extends Controller
{


    public function make_payment(Request $request)
    {
        $data=DB::table('user_added_services as s')
                        ->leftJoin('master_services as m','m.id','s.master_service_id')
                        ->select('s.*','m.service_name')
                        ->where('s.id',$request->user_added_service_id)
                        ->first();

        $user=DB::table('users')->where('id',Session::get('user_id'))->first();

        $_GET['txnid']=$data->service_no;


        $payment=DB::table('user_added_service_payments')
                    ->where('user_added_service_id',$request->user_added_service_id)
                    ->where('paid_amount',0)
                    ->first();

        $_GET['amount']=$payment->payable_amount;
        $_GET['udf1']=Session::get('user_id');
        $_GET['udf2']=$request->user_added_service_id;
        $_GET['udf3']="";
        $_GET['udf4']="";
        $_GET['udf5']="";

        $_GET['firstname']=$user->first_name." ".$user->last_name;
        $_GET['email']=$user->email;
        $_GET['phone']=$user->mobile_no;
        $_GET['productinfo']=$data->service_name;

        $_GET['surl']=env('APP_URL')."/payment-response";
        $_GET['furl']=env('APP_URL')."/payment-response";

        $_GET['sub_merchant_id']="";
        $_GET['address1']="";
        $_GET['address2']="";
        $_GET['city']="";
        $_GET['state']="";
        $_GET['country']="";
        $_GET['zipcode']="";
        // $_GET['split_payments']="";
        // $_GET['show_payment_mode']="";

        if(!empty($_GET) && (sizeof($_GET) > 0)){

        $MERCHANT_KEY = env('MERCHANT_KEY');
        $SALT = env('SALT');
        $ENV = env('ENV');
        $_GET['api_name']="initiate_payment";

        $easebuzzObj = new Easebuzz($MERCHANT_KEY, $SALT, $ENV);

        $easebuzzObj->initiatePaymentAPI($_GET);
        }
    }

    public function payment_response(Request $request)
    {
        $SALT = env('SALT');
        $easebuzzObj = new Easebuzz($MERCHANT_KEY = null, $SALT, $ENV = null);
        $result = $easebuzzObj->easebuzzResponse( $request->all() );
        $result=json_decode($result,true);

        if($result['status']=='1')
        {
            $dataInsert=$result['data'];
            $dataInsert['payment_for']="SERVICE";
            $dataInsert['ref_id']=$result['data']['udf2'];
            $dataInsert['payment_type']="ONLINE";

            $paymentLogID=DB::table('payment_logs')->insertGetId($dataInsert);

            //USER DETAILS
            $user=DB::table('users')->where('id',$result['data']['udf1'])->first();
            Session::put('user_id',$user->id);
            Session::put('user_type',$user->user_type);


            $service=DB::table('user_added_services as s')
                        ->leftJoin('master_services as m','m.id','s.master_service_id')
                        ->select('s.*','m.service_name')
                        ->where('s.id',$result['data']['udf2'])
                        ->first();

            $paymentData['payment_log_id']=$paymentLogID;
            $paymentData['transaction_at']=NOW();

             //CANCELELD BY USER
            if($result['data']['status']=='userCancelled')
            {
                $paymentData['payment_status']="CANCELLED";

                $serviceData['last_transaction_status']="CANCELLED";
                $serviceData['last_transaction_at']=NOW();

                Session::flash('alert-warning',"Transaction has been cancelled !!! ");
            }

            if($result['data']['status']=='failure')
            {
                $paymentData['payment_status']="FAILED";

                $serviceData['last_transaction_status']="FAILED";
                $serviceData['last_transaction_at']=NOW();

                Session::flash('alert-warning',"Transaction has been failed !!! ");
            }

            //SUCCESS
            if($result['data']['status']=='success')
            {
                if($service->payment_type=="ADVANCE_PAYMENT"){
                    $serviceData['current_stage']="WORK_IN_PROGRESS";
                    $serviceData['payment_type']="BALANCE_PAYMENT";
                }

                if($service->payment_type=="BALANCE_PAYMENT"){
                    $serviceData['payment_type']="PAYMENT_COMPLETE";
                }

                if($service->payment_type=="FULL_PAYMENT"){
                    $serviceData['current_stage']="WORK_IN_PROGRESS";
                    $serviceData['payment_type']="PAYMENT_COMPLETE";
                }

                $serviceData['last_transaction_status']="SUCCESS";
                $serviceData['last_transaction_at']=NOW();

                $paymentData['paid_amount']=$dataInsert['amount'];
                $paymentData['payment_status']="SUCCESS";

                Session::flash('alert-success',"Payment Successful  !!! ");
            }


            DB::table('user_added_service_payments')
                    ->where('payment_type',$service->payment_type)
                    ->update($paymentData);

            $total_paid_amount=DB::table('user_added_service_payments')
                                        ->where('user_added_service_id',$result['data']['udf2'])
                                        ->where('is_active',1)
                                        ->where('payment_status','SUCCESS')
                                        ->sum('paid_amount');

            $total_amount=$service->total_amount;
            $total_balance_amount=$service->total_balance_amount;

            if($total_paid_amount){
                $total_balance_amount=$total_amount-$total_paid_amount;
            }
            $serviceData['total_paid_amount']=$total_paid_amount;
            $serviceData['total_balance_amount']=$total_balance_amount;

            DB::table('user_added_services')->where('id',$result['data']['udf2'])->update($serviceData);

            return redirect('client/dashboard');
        }
    }
}
