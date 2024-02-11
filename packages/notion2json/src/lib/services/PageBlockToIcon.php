<?php

namespace Notion2json\lib\services;

use Notion2json\lib\services\Block;

class PageBlockToIcon{
    private Block $_pageBlock;
    public function __construct(Block $block){
        $this->_pageBlock = $block;
    }
    private function startsWith($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
    public function toIcon() {
        if(!array_key_exists("page_icon", $this->_pageBlock->properties)) return null;
        $icon = $this->_pageBlock->properties['page_icon'];
        if (!isset($icon)) return null;
        if (!$this->startsWith($icon,'http')) return $icon;
        
        $url = sprintf('https://www.notion.so/image/%s?table=block&id=%s',urlencode($icon),$this->_pageBlock->id);
        return base64_encode($url);
    }
}