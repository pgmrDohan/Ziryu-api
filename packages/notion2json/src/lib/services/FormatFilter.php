<?php
namespace Notion2json\lib\services;

class FormatFilter{
    private array $ACCEPTABLE_KEYS = ['block_color', 'page_cover_position', 'block_width'];
    private $_format;
    public function __construct($format){
        $this->_format = isset($format)?$format:(object)array();
    }
    public function filter(){
        $presentAcceptableKeys = array_filter(array_keys(json_decode(json_encode($this->_format),true)),function ($k) {
            return in_array($k, $this->ACCEPTABLE_KEYS);
        });
        return array_reduce($presentAcceptableKeys, function($filteredFormat, $key){
            return array_merge(array(
                $key=>$this->_format[$key],
            ),$filteredFormat);
        }, array());
    }
}