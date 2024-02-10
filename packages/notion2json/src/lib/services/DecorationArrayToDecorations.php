<?php
namespace Notion2json\lib\services;

class DecorationArrayToDecorations{
    private array $_decorationsArray;

    private array $fromDecorationArrayTypeToDecorationType = array(
        "b"=>'bold',
        "i"=>'italic',
        "_"=>'underline',
        "s"=>'strikethrough',
        "c"=>'code',
        'a'=>'link',
        'e'=>'equation',
        'h'=>'color',
    );

    public function __construct(array $decorationsArray){
        $this->_decorationsArray = $decorationsArray;
    }

    public function toDecorations():array{
        if (!$this->_decorationsArray) return [];

        return array_map(function ($decorations){
            $type = $value = $decorations;
            return (object)array(
                "type"=> isset($this->fromDecorationArrayTypeToDecorationType[(string)$type[0]])?
                    $this->fromDecorationArrayTypeToDecorationType[(string)$type[0]]:'plain',
            );
        }, $this->_decorationsArray);
    }
}