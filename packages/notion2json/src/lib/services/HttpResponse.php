<?php
namespace Notion2json\lib\services;
class HttpResponse{
    public int $status;
    public object | string $data;
    public object $headers;

    public function __construct($status, $data, $headers=0){ 
        $this->status = $status;
        $this->data = $data;
        $headers != 0 ? (object) $this->headers = $this->get_http_header_as_array($headers):null;
    }

    private function startsWith($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }

    private function get_http_header_as_array($rawheader):object{
        $header_array = array();
        $header_rows = explode("\n",$rawheader);
        for($i=0;$i<count($header_rows);$i++){
            $fields = explode(":",$header_rows[$i]);
     
            if($i != 0 && !isset($fields[1])){
                if(substr($fields[0], 0, 1) == "\t"){
                    end($header_array);
                    $header_array[key($header_array)] .= "\r\n\t".trim($fields[0]);
                }
                else{
                    end($header_array);
                    $header_array[key($header_array)] .= trim($fields[0]);
                }
            }
            else{
                $field_title = trim($fields[0]);
                if (!($this->startsWith($field_title,'HTTP'))){
                    if (!isset($header_array[$field_title])){
                        $header_array[$field_title]=trim($fields[1]);
                    }
                    else if(is_array($header_array[$field_title])){
                            $header_array[$field_title] = array_merge($header_array[$fields[0]], array(trim($fields[1])));
                        }
                    else{
                        $header_array[$field_title] = array_merge(array($header_array[$fields[0]]), array(trim($fields[1])));
                    }
                }
            }
        }
        return (object) $header_array;
    }
}