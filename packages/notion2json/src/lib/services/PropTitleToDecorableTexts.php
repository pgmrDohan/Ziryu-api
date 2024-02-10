<?php

namespace Notion2json\lib\services;
use Notion2json\lib\services\DecorationArrayToDecorations;

class PropTitleToDecorableTexts{
    private $_title;
    public function __construct($title){
        $this->_title = $title;
    }
    public function toDecorableTexts() : array{
        if (!$this->_title) return [];

        return array_map(function(array $richText){
            $text = gettype($richText[0])==='array'?implode(',',$richText[0]):$richText[0];
            $decorationsArray = isset($richText[1])?$richText[1]:null;
            return array(
                'text'=>$text,
                'decorations' => isset($decorationsArray)?(new DecorationArrayToDecorations($decorationsArray))->toDecorations():array()
            );
        },json_decode(json_encode($this->_title),true));
    }
}