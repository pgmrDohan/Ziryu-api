<?php
namespace Notion2json\lib\services;

use Notion2json\lib\services\HttpResponse;
class HttpPostClient {
    public function post($url, $fields):HttpResponse {
        $body=json_encode($fields);
        $ch=curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,10);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);

        curl_setopt($ch, CURLOPT_HEADER  , true);

        $response=curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);        
        curl_close($ch);

        $split_result = explode("\r\n\r\n", $response, 2);
        $header = $split_result[0];
        $body = json_decode($split_result[1]);
        return new HttpResponse($httpcode, $body, $header);
    }
}