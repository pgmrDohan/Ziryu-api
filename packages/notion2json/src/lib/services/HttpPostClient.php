<?php
namespace Notion2json\lib\services;

use Notion2json\lib\services\HttpResponse;
class HttpPostClient {
    private function startsWith($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
    public function post($url, $post_string, $type='POST'):HttpResponse {
        $command = sprintf('curl -X %s -H "Content-Type: application/json" -H "User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/121.0.0.0 Safari/537.36"',$type); 
        $command .= sprintf(" -d '%s' %s -i", json_encode($post_string), $url);
        $response = shell_exec($command);

        $split_result = explode("\r\n\r\n", $response, 2);
        $header = $split_result[0];
        $body = json_decode($split_result[1]);
        $httpcode = explode(" ",explode("\r\n", $header)[0])[1];
        return new HttpResponse($httpcode, $body, $header);

/*
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
        return new HttpResponse($httpcode, $body, $header);*/
    }
    
}