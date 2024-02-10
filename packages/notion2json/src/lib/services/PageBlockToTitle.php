<?php
namespace Notion2json\lib\services;

use Notion2json\lib\services\Block;

class PageBlockToTitle{
    private Block $_pageBlock;

    public function __construct(Block $pageBlock){
        $this->_pageBlock = $pageBlock;
    }
    public function toTitle(){
        return isset($this->_pageBlock->decorableTexts[0]['text'])?$this->_pageBlock->decorableTexts[0]['text']:'';
    }
}