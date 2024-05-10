<?php
    namespace App\Helpers;
    use Illuminate\Http\Request;
    use Session;
    use Redirect;
    use DB;

    class Message{

        private static $url = 'https://api.gupshup.io/wa/api/v1/template/msg';
        private static $apiKey="a73aa019bd8948fac8375eac3ca44012";
        public static function message($templateId,$destination,$params=[]){

            $postData = http_build_query([
                'channel' => 'whatsapp',
                'source' => '917972163667',
                'destination' => '91'.$destination,
                'src.name' => 'Taxoreo',
                'template' => json_encode([
                    'id' => $templateId,
                    'params' => $params
                ])
            ]);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, self::$url);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            $headers = [
                'Cache-Control: no-cache',
                'Content-Type: application/x-www-form-urlencoded',
                'apikey: ' . self::$apiKey
            ];
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($curl);

            if (curl_errno($curl)) {
                return ['status'=>0,'message'=>curl_error($curl),'data'=>$postData];
            } else {
                return ['status'=>1,'message'=>$response,'data'=>$postData];
            }   
        }


    }

?>

