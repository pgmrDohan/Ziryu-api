<?php
namespace Notion2json\lib\services;
use Notion2json\lib\services\Block;
use Notion2json\lib\services\ImageCover;

class PageBlockToCoverImageSource{
    private Block $_pageBlock;

    public function __construct(Block $block){
        $this->_pageBlock = $block;
    }

    private function startsWith($haystack, $needle) {
        return $needle === "" || strrpos($haystack, $needle, -strlen($haystack)) !== false;
    }
    
    public function toImageCover(){
        if(!array_key_exists("page_cover", $this->_pageBlock->properties)) return null;
        $pageCover = $this->_pageBlock->properties['page_cover'];
        if (!isset($pageCover) || !$this->_isImageURL($pageCover)) return null;

        $head = '';
        if ($this->startsWith($pageCover,'/')) $head = 'https://www.notion.so';

        $base64 = base64_encode($this->getImageAuthenticatedSrc($head.$pageCover));
        $position = $this->_pageCoverPositionToPositionCenter(
            array_key_exists("page_cover_position", $this->_pageBlock->format)?
            $this->_pageBlock->format['page_cover_position']:0.6
        );

        return array('base64'=>$base64,'position'=>$position);
    }
    private function _isImageURL(string $url): bool {
        return preg_match("/^https?:\/\/.*\/.*\.(png|gif|webp|jpeg|jpg)\??.*$/mi",$url)===false ? false : true;
    }
    
    private function getImageAuthenticatedSrc(string $src): string {
        return sprintf('https://www.notion.so/image/%s?table=block&id=%s',urlencode($src),$this->_pageBlock->id);
    }

    private function _pageCoverPositionToPositionCenter(float $coverPosition): float {
        return (1 - $coverPosition) * 100;
    }
}