<?php
    namespace App\Helpers;
    use Constant;
    use Illuminate\Http\Request;
    use Session;
    use Redirect;
    use DB;

    class General{
        public static function convert_reponse_to_array($response){
            return json_decode(json_encode($response->getData()),true);
        }

        public static function assign_user_to_service($service_id,$user_id){
            $is_updated=DB::table('user_added_services')->where('id',$service_id)
                                            ->update([
                                                    'assigned_to_user_id'=>$user_id,
                                                    'assigned_at'=>NOW()
                                                    ]);
            if($is_updated){
                return response()->json(['status'=>1,'message'=>"User Assigned Sucessfully !!!",'data'=>NULL]);
            }

            return response()->json(['status'=>0,'message'=>"User Not Assigned !!!",'data'=>NULL]);
        }

        public static function add_user_added_service($userId,$companyTypeId)
        {
            $master_service_id=DB::table('user_added_services_temp')
                                ->whereDate('created_at',date('Y-m-d'))
                                ->where('session_id',session()->getId())
                                ->pluck('service_id')
                                ->toArray();

            if(count($master_service_id))
            {
                $master_service_id= array_unique($master_service_id);
                foreach($master_service_id as $m)
                {
                    $total_documents=DB::table('master_services_documents as m')
                                        ->leftJoin('master_documents as d','d.id','=','m.master_document_id')
                                        ->select('m.*','d.document_name')
                                        ->where('m.master_service_id',$m)
                                        ->where('m.master_company_type_id',$companyTypeId)
                                        ->where('m.is_active',1)
                                        ->get();
                    $master_service= DB::table('master_services')->where('id',$m)->first();

                    if(count($total_documents))
                    {
                        $user_added_service_id=DB::table('user_added_services')
                                ->insertGetId([
                                    'service_no'=>"T-".rand(111,999),
                                    'user_id'=>$userId,
                                    'current_stage'=>"DOCUMENT",
                                    'master_service_id'=>$m,
                                    'total_documents'=>count($total_documents),
                                    'remaining_documents'=>count($total_documents),
                                    'total_amount'=>$master_service->actual_amount,
                                    'total_balance_amount'=>$master_service->actual_amount,
                                    'created_at'=>NOW()
                                ]);

                        foreach($total_documents as $t){
                            DB::table('user_added_service_documents')
                                ->insert([
                                    'user_added_service_id'=>$user_added_service_id,
                                    'user_id'=>Session::get('user_id'),
                                    'master_document_id'=>$t->master_document_id,
                                    'document_name'=>$t->document_name,
                                    'created_at'=>NOW()
                                ]);
                        }
                    }
                }

                DB::table('user_added_services_temp')
                    ->whereDate('created_at',date('Y-m-d'))
                    ->where('session_id',session()->getId())
                    ->delete();
            }
        }

        public static function get_freelancers(){
            $freelancers=DB::table('users')
                            ->select('id',DB::RAW('CONCAT(first_name," ",last_name) as freelancer_name'))
                            ->whereIn('user_type',['FREELANCER','ADMIN'])
                            ->where('is_active',1)
                            ->get();
             return $freelancers;
        }

        public static function get_client_details($user_added_service_id){
            $client_detail=DB::table('users as u')
                            ->leftJoin('user_added_services as us','us.user_id','u.id')
                            ->where('us.id',$user_added_service_id)
                            ->select('u.*')
                            ->first();
             return $client_detail;
        }

        public static function get_user_service_details($user_added_service_id){
            $user_service=DB::table('user_added_services as us')
                            ->leftJoin('master_services as ms','ms.id','us.master_service_id')
                            ->leftJoin('users as c','c.id','us.user_id')
                            ->where('us.id',$user_added_service_id)
                            ->select('us.*','ms.service_name',
                                    DB::RAW('CONCAT(c.first_name," ",c.last_name) as client_name')
                                    )
                            ->first();
             return $user_service;
        }

        public static function get_user_payment_details($user_added_service_id){
            $payments=DB::table('user_added_service_payments as up')
                        ->leftJoin('payment_logs as p','p.id','up.payment_log_id')
                        ->where('up.user_added_service_id',$user_added_service_id)
                        ->select('up.*','p.easepayId as transaction_id','p.addedon')
                        ->get();

            return $payments;
        }

        public static function get_documents($user_added_service_id){
            $documents=DB::table('user_added_service_documents')
                        ->where('user_added_service_id',$user_added_service_id)
                        ->get();
            return $documents;
        }

        public static function get_comments($user_added_service_id){
            $query=DB::table('user_added_service_comments as c')
                        ->where('c.client_added_service_id',$user_added_service_id)
                        ->leftJoin('users as u','u.id','c.comment_added_by')
                        ->select('c.*',DB::RAW('CONCAT(u.first_name," ",u.last_name) as username'))
                        ->where('c.is_active',1);

                    if(Session::get('user_type')=="CLIENT"){
                        $query->where('c.show_to_client',1);
                    }
            $comments=$query->orderBy('id','DESC')
                            ->get();
            return $comments;
        }
    }
?>
