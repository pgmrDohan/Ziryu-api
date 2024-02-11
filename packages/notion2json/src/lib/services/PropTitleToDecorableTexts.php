<?php

namespace Notion2json\lib\services;
use Notion2json\lib\services\DecorationArrayToDecorations;

class PropTitleToDecorableTexts{
    private $_title;
    public function __construct($title){
        $this->_title = $title;
    }
    private function recursive_implode(array $array, $glue = ',', $include_keys = false, $trim_all = true)
    {
        $glued_string = '';

        // Recursively iterates array and adds key/value to glued string
        array_walk_recursive($array, function($value, $key) use ($glue, $include_keys, &$glued_string)
        {
            $include_keys and $glued_string .= $key.$glue;
            $glued_string .= $value.$glue;
        });

        // Removes last $glue from string
        strlen($glue) > 0 and $glued_string = substr($glued_string, 0, -strlen($glue));

        // Trim ALL whitespace
        $trim_all and $glued_string = preg_replace("/(\s)/ixsm", '', $glued_string);

        return (string) $glued_string;
    }
    public function toDecorableTexts() : array{
        if (!$this->_title) return [];

        return array_map(function(array $richText){
            $text =
            is_array($richText[0])?$this->recursive_implode($richText[0],','):$richText[0];
            $decorationsArray = isset($richText[1])?$richText[1]:null;
            return array(
                'text'=>$text,
                'decorations' => isset($decorationsArray)?(new DecorationArrayToDecorations($decorationsArray))->toDecorations():array()
            );
        },json_decode(json_encode($this->_title),true));
    }
}