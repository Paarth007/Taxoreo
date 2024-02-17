<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\MessageMailable;
use App\Mail\ReceiptMailable;
use App\Mail\AdmissionMailable;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use DB;
use Redirect;
use Validator;
use GuzzleHttp\Client;

class MessageController extends Controller
{

  public function test_email(Request $request)
  {
    $email="parth.patel286@gmail.com";
    $link='http://aiatindia.com/user/verify?hash=onetwokafour';
    // $data = ['name'=>'Parth Patel','link'=>$link];
    $data = ['subject'=>"Hi",'msg'=>"THIS IS TESt"];
    $failures="";
    // $data = ['subject'=>$email_subject,'msg'=>$msg];
    try{
       Mail::to($email)->send(new MessageMailable($data));
        if( count(Mail::failures()) > 0 )
        {
           foreach(Mail::failures as $email_address)
            {
               echo " - $email_address <br />";
            }
        }else {
          echo "Mail Sent";
        }
      }
      catch(Exception $ex)
      {
        echo $ex;
      }
  }
  //================================================ Email ==============================================================
  public function send_email_modal(Request $request)
  {
    $output='';
    $checkboxes = $request->input('id');
    $type = $request->input('type');
    $arr[]="";
    $count=$selected=$unselected=0;
      for($i=0; $i<sizeof($checkboxes); $i++)
      {
        switch($type){
          case "Admission":
                            $data=DB::table('admission')->where('attendance_id',$checkboxes[$i])->first();
                            break;
          case "Enquiry" :   
                            $data=DB::table('enquiry')->where('id',$checkboxes[$i])->first();
                            break;
          case "Enquiry_call" :
                            $data=DB::table('get_call')->where('id',$checkboxes[$i])->first();
                            break;
          case "Landing_enquiry" :
                            $data=DB::table('aiatindia_enq')->where('id',$checkboxes[$i])->first();
                            break;                  
          case "Landing_call" :
                            $data=DB::table('aiat_get_call')->where('id',$checkboxes[$i])->first();
                            break;                                    
          case "Teacher"  :
                            $data=DB::table('teacher')->where('teacher_id',$checkboxes[$i])->first();
                            break;
                              
        }
        if($data->email!=""){
            array_push($arr,$data->email);
            $selected++;
          }else {
            $unselected++;
          }
          $count++;
      }
      $array=implode(',', $arr);
      $output.='
             <p class="form-control-label p-0" for="">Total :- '. $selected .' out of '. $count .' selected</p>
              <div class="form-group">
                 <label class="form-control-label" for="email_list">Email address</label>
                 <input type="text" id="email_list" name="email_list" class="form-control form-control-sm" data-toggle="tags" value="'. ltrim($array, ',').'" required>
               </div>
               <div class="form-group">
                  <div class="row">
                    <div class="col">
                      <label class="form-control-label" for="email_dsubject">Email Subject</label>
                      <input type="text"  id="email_subject" name="email_subject" class="form-control form-control-sm" placeholder="Subject">
                    </div>
                     <h5 class="text-muted" style="margin-top:38px">Or</h5>
                    <div class="col">
                      <label class="form-control-label" for="eamil_template">Select Template</label>
                      <select class="form-control form-control-sm" name="email_template" id="email_template" onchange="email_copy(this.value)">
                        <option value="">-Select Template-</option>';
                        $res = DB::table('template')->where('status',1)->where('type','EMAIL')->get();
                        foreach($res as $r)
                        {
                          $temp_name = $r->title;
                          $temp_id = $r->id;
                          $output .='<option value="'.$temp_id.'">'.$temp_name.'</option>';
                        }
            $output .=' </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <textarea type="text" id="email_msg" name="email_msg" class="form-control" rows="10" cols="30" required></textarea>
                </div>';
      return $output;
  }

 public function email(Request $request)
 {
   $page=$request->input('page');
   $email_subject= $request->input('email_subject');
   $email_msg= $request->input('email_msg');
   $email_list=$request->input('email_list');
   $email_list=explode(',',$email_list);

     for($i=0;$i<count($email_list);$i++)
     {
       $text=$this->makeText('email',$email_list[$i],$email_msg);
       if($text!="")
       {
        $data = ['subject'=>$email_subject,'msg'=>$text];
        try{
            Mail::to($email_list[$i])->send(new MessageMailable($data));
              if( count(Mail::failures()) > 0 )
              {
                $request->session()->flash('alert-danger', 'Email is not sent');
              } else {
                $request->session()->flash('alert-success', 'Email Sent Sucessfully !');
              }
            }
            catch(Exception $ex){
              $request->session()->flash('alert-warning', 'Due to some exceptions, mail is not sent !');
            }
       }
     } //FOR
     return redirect()->back();
  }


public function makeText($type,$key,$msg)
{
  $total=0;$to_pay=0;$balance=0;$payment_mode_id=0;
  
  $info=DB::table('admission')
            ->select('attendance_id','f_name','m_name','l_name','password','email','mob','password')
            ->where($type,$key)
            ->first();
  if($info){

    $data=DB::table('receipt_payment')->where('admission_id',$info->attendance_id)
                                      ->where('due_date','<=',date('Y-m-t'))
                                      ->get();
    foreach($data as $d){
      if($d->fees!=$d->paid){
        if($d->balance==0){
          $total+=$d->fees;
        }else{
          $total+=$d->balance;
        }
      }
    }
    $to_replace = array('*First_Name*','*Middle_Name*','*Last_Name*','*Balance_Amount*','*Password*');
    $replacement = array($info->f_name,$info->m_name,$info->l_name,$total,$info->password);
    return str_replace($to_replace,$replacement,$msg);
  }else{
    return "";
  }
}
//================================================ SMS =================================================

  public function send_sms_modal(Request $request)
  {
      $output='';
      $checkboxes = $request->input('id');
      $type = $request->input('type');
      $arr[]="";
      $count=$selected=$unselected=0;
      for($i=0; $i<sizeof($checkboxes); $i++)
      {
        switch($type){
          case "Admission":
                            $data=DB::table('admission')->where('attendance_id',$checkboxes[$i])->first();
                            break;
          case "Enquiry" :   
                            $data=DB::table('enquiry')->where('id',$checkboxes[$i])->first();
                            break;
          case "Enquiry_call" :
                            $data=DB::table('get_call')->where('id',$checkboxes[$i])->first();
                            break;
          case "Landing_enquiry" :
                            $data=DB::table('aiatindia_enq')->where('id',$checkboxes[$i])->first();
                            break;                  
          case "Landing_call" :
                            $data=DB::table('aiat_get_call')->where('id',$checkboxes[$i])->first();
                            break;                                    
          case "Teacher"  :
                            $data=DB::table('teacher')->where('teacher_id',$checkboxes[$i])->first();
                            break;
                              
        }
          if($data->mob!="")
          {
            array_push($arr,$data->mob);
            $selected++;
          }else {
            $unselected++;
          }
          $count++;
       }
      $array=implode(',', $arr);
      $output.='<p class="form-control-label p-0" for="">Total :- '. $selected .' out of '. $count .' selected</p>
              <div class="form-group">
                 <label class="form-control-label" for="email_address">Contact List</label>
                 <input type="text" id="number_list" name="number_list" class="form-control form-control-sm" data-toggle="tags" value="'. ltrim($array, ',').'" required>
               </div>
               <div class="form-group">
                  <div class="row">                    
                    <div class="col">
                      <label class="form-control-label" for="sms_template">Select Template</label>
                      <select class="form-control form-control-sm" name="sms_template" id="sms_template" onchange="sms_copy(this.value)">
                        <option value="">-Select Template-</option>';
                        $res = DB::table('template')->where('status',1)->where('type','SMS')->get();
                        foreach($res as $r){
                          $temp_name = $r->title;
                          $temp_id = $r->id;
                          $output .='<option value="'.$temp_id.'">'.$temp_name.'</option>';
                       }
            $output .=' </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <textarea type="text" id="sms_msg" name="sms_msg" class="form-control" rows="3" cols="30" onkeyup="countChars(this);"></textarea>
                  <div class="align-right">
                    <small id="char"> 0 Character</small>
                  </div>
                </div>
                 ';
    echo $output;
  }

    public function sms(Request $request)
    {
     $sms_msg=$request->input('sms_msg');
     $sms_template=$request->input('sms_template');
     $number_list=$request->input('number_list');
     $number_list=explode(',',$number_list);
     $flag="";
     $count=0;
      $template=DB::table('template')->where('id',$sms_template)->first();

       for($i=0;$i<count($number_list);$i++)
       {
          $text=$this->makeText('mob',$number_list[$i],$sms_msg);
          if($text!="")
          {
            $id="aiatjob@gmail.com";
            $pwd =  "business";
            $phone = $number_list[$i];
            $sender="AIATPL";
            $dlrUrl="";
            $data = $this->sendSMS($id,$pwd,$phone,$text,$sender,$dlrUrl,$template->template_id);
            if($data=='Message Submitted')
            {
              $flag=1;
              $count++;
            }else {
              $flag=0;
            }
          }
      }
      if($flag==0)
      {
        $request->session()->flash('alert-success', 'SMS Sent Sucessfully !');
      }else {
        $request->session()->flash('alert-warning', 'SMS not sent to '.$count);
      }
     return redirect()->back();
  }

  public function sendSMS($id,$pwd,$phone,$text,$sender,$dlrurl,$template_id=NULL)
  {
    $ApiUrl ="https://www.businesssms.co.in/smsaspx";
    // $ApiUrl ="http://bulkwhatsapp.live";
    // $postdata = "Id=".$id."&Pwd=".urlencode($pwd)."&PhNo=".$phone."&text=".urlencode($text)."&SenderID=".$sender."&DlrUrl=".$dlrurl;
    $postdata="Id=".$id."&Pwd=".urlencode($pwd)."&PhNo=".$phone."&text=".urlencode($text)."&TemplateID=".$template_id;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$ApiUrl);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $resp=curl_exec($ch);
    curl_close($ch);
    return $resp;
  }
  //
 public function sms_receipt(Request $request)
 {
   $list=$request->input('list');
   $list=explode (",",$list);
   foreach($list as $lis)
   {
     $lis=str_replace("->",',',$lis);
     $lis=explode (",",$lis);
       $receipt=DB::table('receipt_payment')->where('id',$lis[0])->get();
       foreach ($receipt as $r)
        {
         $receipt_no=$r->receipt_no;
         $payment_date=$r->payment_date;
         $admission_id=$r->admission_id;
         $installment_name= $r->installment_name;
         $paid=$r->paid;
       }

       $admission=DB::table('admission')->where('email',$lis[1])->get();
       foreach ($admission as $a)
       {
         $name=$a->f_name." ".$a->l_name;
         $mob=$a->mob;
       }
    }
    $ID="aiatjob@gmail.com";
    $Pwd =  "business";
    $baseurl ="https://www.businesssms.co.in";
    $PhNo = $mob;
    $Text = urlencode('Amount of Rs. '.$paid .' has been received for '.$installment_name.'. Thank You- AIAT INSTITUTE');
    $url = "$baseurl/sms.aspx?Id=$ID&Pwd=$Pwd&PhNo=$PhNo&text=$Text";
    $ret = file($url);
    return $ret;
  }

//================================================ SMS =================================================
  public function send_whats_app_modal(Request $request)
  {
      $output='';
      $checkboxes = $request->input('id');
      $type = $request->input('type');
      $arr[]="";
      $count=$selected=$unselected=0;
      for($i=0; $i<sizeof($checkboxes); $i++)
      {
        switch($type){
          case "Admission":
                            $data=DB::table('admission')->where('attendance_id',$checkboxes[$i])->first();
                            break;
          case "Enquiry" :   
                            $data=DB::table('enquiry')->where('id',$checkboxes[$i])->first();
                            break;
          case "Enquiry_call" :
                            $data=DB::table('get_call')->where('id',$checkboxes[$i])->first();
                            break;
          case "Landing_enquiry" :
                            $data=DB::table('aiatindia_enq')->where('id',$checkboxes[$i])->first();
                            break;                  
          case "Landing_call" :
                            $data=DB::table('aiat_get_call')->where('id',$checkboxes[$i])->first();
                            break;                                    
          case "Teacher"  :
                            $data=DB::table('teacher')->where('teacher_id',$checkboxes[$i])->first();
                            break;
                              
        }
          if($data->w_mob!="")
          {
            array_push($arr,$data->w_mob);
            $selected++;
          }else {
            $unselected++;
          }
          $count++;
       }
      $array=implode(',', $arr);
      $output.='<p class="form-control-label p-0" for="">Total :- '. $selected .' out of '. $count .' selected</p>
              <div class="form-group">
                 <label class="form-control-label" for="email_address">Contact List</label>
                 <input type="text" id="number_list" name="number_list" class="form-control form-control-sm" data-toggle="tags" value="'. ltrim($array, ',').'" required>
               </div>
               <div class="row">
                <div class="col-md-12 form-group">
                  <label class="form-control-label" for="attachment">Select Attachment :</label>
                  <input type="file" id="attachment" name="attachment" class="form-control form-control-sm" style="display:block">
                </div>';

        // $output.='<div class="col-md-6 form-group">
        //             <label class="form-control-label" for="attachment"> Attachment URL:</label>
        //             <input type="text" id="attachment_url" name="attachment_url" class="form-control form-control-sm">
        //           </div>';
         

      $output.='</div>
               <div class="form-group">
                  <div class="row">                    
                    <div class="col">
                      <label class="form-control-label" for="sms_template">Select Template</label>
                      <select class="form-control form-control-sm" name="whats_app_template" id="whats_app_template" onchange="whats_app_copy(this.value)">
                        <option value="">-Select Template-</option>';
                        $res = DB::table('template')->where('status',1)->where('type','WHATSAPP')->get();
                        foreach($res as $r){
                          $temp_name = $r->title;
                          $temp_id = $r->id;
                          $output .='<option value="'.$temp_id.'">'.$temp_name.'</option>';
                       }
            $output .=' </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <textarea type="text" id="whats_app_msg" name="whats_app_msg" class="form-control" rows="3" cols="30"></textarea>
                </div>';
                 
              //   <div class="form-group">
              //     <div class="row">                    
              //       <div class="col">
              //         <label class="form-control-label" for="whats_app_as">Send Whats App</label>
              //         <select class="form-control form-control-sm" name="whats_app_as" id="whats_app_as" required="true" onchange="f_whats_app_as(this.value)">
              //           <option value="">Type</option>
              //           <option value="INDIVIDUAL">-INDIVIDUAL-</option>
              //           <option value="COMBINE">-COMBINE-</option>
              //           </select>
              //       </div>
              //     </div>
              // </div>
        echo $output;
      }

    
  public function whats_app(Request $request)
  {
    $whats_app_msg=$request->input('whats_app_msg');
    $number_list=$request->input('number_list');
    $whats_app_as=$request->input('whats_app_as');
    $flag="";
    $image_name=null;
    $image_url="";
    $extension="";

    if($request->hasFile('attachment') && !$request->attachment_url){
        $image=$request->file('attachment');
        $image_name=$request->file('attachment')->getClientOriginalName();
        $image_name=str_replace("-"," ",$image_name);
        $image_name=str_replace(" ","_",$image_name);
        $extension=$request->file('attachment')->getClientOriginalExtension();
        $check=DB::table('images')->where('name',$image_name)->where('extension',$extension)->first();
        if($check){
            $image_url=$check->url; 
            $extension=$check->extension;
        }else{
          $image_url="https://www.aiatindia.com/admin/images/attachment/".$image_name;
          if($image->move('admin/images/attachment/', $image_name))
          {
              DB::table('images')->insert([
                        'name'=>$image_name,
                        'extension'=>$extension,
                        'url'=>$image_url,
                      ]);
                sleep(3);
          }else {
            $flag='0';
          }
        }
    }else{
      $image_url=$request->attachment_url;
    }


    $number_list=explode(",",$number_list);

    foreach($number_list as $n){
       
      $text=$this->makeText('w_mob',$n,$whats_app_msg);     

       if($text!="")
       {
          $text=urlencode(strip_tags($text));
          $url="http://bulkwhatsapp.live/wapp/api/send?apikey=b79f3cb22ab24083aa8cdd0b6affee0d&mobile=".$n."&msg=$text";
          
          if($image_url && in_array($extension,["jpg","png","jpeg"])){
            $url.="&img1=".urlencode($image_url);
          }

          if($image_url && in_array($extension,["pdf"])){
              $url.="&pdf=".urlencode($image_url);
          }
          
          $header = array("Accept: application/json");
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
          curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
          curl_setopt($ch, CURLOPT_URL, $url);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          $output=curl_exec($ch);
          DB::table('message_logs')->insert(['message_type'=>"WHATS_APP",
                    'admin_id'=>SESSION::get('admin_id'),
                    'contact_no'=>$n,
                    'url'=>$url,
                    'message'=>$text,
                    'response'=>$output,
                    'created_at'=>NOW()
                  ]);
          $output = json_decode($output,true);

            if($output['statuscode']==400){
                $flag==1;
            }
        }//if
    }//for

    // if($whats_app_as=="INDIVIDUAL"){
    //   $number_list=explode(",",$number_list);

    //   for($i=0;$i<count($number_list);$i++){
         
    //     $text=$this->makeText('w_mob',$number_list[$i],$whats_app_msg);     

    //      if($text!="")
    //      {
    //         $text=urlencode(strip_tags($text));
    //         $url="http://bulkwhatsapp.live/wapp/api/send?apikey=b79f3cb22ab24083aa8cdd0b6affee0d&mobile=".$number_list[$i]."&msg=$text";
    //         if($image_url){
    //           $url.="&img1=".urlencode($image_url);
    //         }
    //         $header = array("Accept: application/json");
    //         $ch = curl_init();
    //         curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    //         curl_setopt($ch, CURLOPT_URL, $url);
    //         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //         $output=curl_exec($ch);
    //         DB::table('message_logs')->insert(['message_type'=>"WHATS_APP",
    //                   'admin_id'=>SESSION::get('admin_id'),
    //                   'contact_no'=>$number_list[$i],
    //                   'url'=>$url,
    //                   'message'=>$text,
    //                   'response'=>$output,
    //                   'created_at'=>NOW()
    //                 ]);
    //         $output = json_decode($output,true);

    //           if($output['statuscode']==400){
    //               $flag==1;
    //           }
    //       }//if
    //   }//for
    // }else{
    //   $text=urlencode(strip_tags($whats_app_msg));
    //     $url="http://bulkwhatsapp.live/wapp/api/send?apikey=b79f3cb22ab24083aa8cdd0b6affee0d&mobile=".$number_list."&msg=$text";
    //     if($image_url){
    //       $url.="&pdf=".urlencode($image_url);
    //     }
    //     $header = array("Accept: application/json");
    //     $ch = curl_init();
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
    //     curl_setopt($ch, CURLOPT_URL, $url);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     $output=curl_exec($ch);

    //     $numbers=explode(",",$number_list);
    //     foreach($numbers as $n){
    //         DB::table('message_logs')->insert(['message_type'=>"WHATS_APP",
    //               'admin_id'=>SESSION::get('admin_id'),
    //               'contact_no'=>$n,
    //               'url'=>$url,
    //               'message'=>$text,
    //               'response'=>$output,
    //               'created_at'=>NOW()
    //             ]);
    //       }
    //     $output = json_decode($output,true);
    //     if($output['statuscode']==400){
    //       $flag==1;
    //   }
    // }


    if($flag==0)
    {
      $request->session()->flash('alert-success', 'Whats App Sent Sucessfully !!!');
    }else {
      $request->session()->flash('alert-warning', 'Whats App not sent to all !!! ');
    }
     return redirect()->back();
  }


//*********************************************************************************************************************
  public function get_sms_template(Request $request)
  {
    $id=$request->get('template_id');
    $temp="";
    $template=DB::table('template')->where('id','=',$id)->get();
    foreach($template as $t)
    {
    $temp=$t->template;
    $title=$t->title;
    }
    return json_encode(array("temp"=>$temp,"title"=>$title));
  }

  public function get_email_template(Request $request)
  {
    $id=$request->get('template_id');
    $temp="";
    $template=DB::table('template')->where('id','=',$id)->get();
    foreach($template as $t){
          $temp=$t->template;
          $title=$t->title;
    }
    return json_encode(array("temp"=>$temp,"title"=>$title));
  }

  public function get_whats_app_template(Request $request)
  {
    $id=$request->get('template_id');
    $temp="";
    $template=DB::table('template')->where('id','=',$id)->get();
    foreach($template as $t){
          $temp=$t->template;
          $title=$t->title;
    }
    return json_encode(array("temp"=>$temp,"title"=>$title));
  }

}
