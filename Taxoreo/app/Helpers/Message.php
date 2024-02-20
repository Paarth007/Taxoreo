<?php
    namespace App\Helpers;
    use Illuminate\Http\Request;
    use Session;
    use Redirect;
    use DB;

    class Message{

        private $id="aiatjob@gmail.com";
        private $password = "business";
        private $senderId="AIATPL";
        private $url="https://messaging.charteredinfo.com/smsaspx";

        public static function message(){

            $postdata="Id=".$id;
            $postdata.="&Pwd=".urlencode($pwd);
            $postdata.="&PhNo=".$phone;
            $postdata.="&text=".urlencode($text);
            $postdata.="&TemplateID=".$template_id;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL,$ApiUrl);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $resp=curl_exec($ch);
            curl_close($ch);
            return $resp;

        }
    }

?>

