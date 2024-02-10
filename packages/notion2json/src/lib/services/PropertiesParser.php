<?php
namespace Notion2json\lib\services;

class PropertiesParser{
    private array $KEYS_TO_PRESERVE = ['source', 'caption', 'language', 'checked', 'page_icon', 'page_cover','page_small_text'];
    private $_format;
    private $_properties;
    public function __construct($format,$properties){
        $this->_format = isset($format)?$format:(object)array();
        $this->_properties = isset($properties)?$properties:(object)array();
    }
    public function parse(){
        $avaliableKeys = array_filter(array_keys(array_merge(json_decode(json_encode($this->_format),true),json_decode(json_encode($this->_properties),true))),function ($k) {
            return in_array($k, $this->KEYS_TO_PRESERVE);
        });
        return array_reduce($avaliableKeys, function($format, $key){
            return array_merge(array(
                $key=>array_key_exists($key, $this->_format) ? $this->_format[$key]:true,
            ),$format);
        }, array());
    }
}