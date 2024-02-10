<?php
namespace Notion2json\lib\services;
use Notion2json\lib\services\Block;
use Notion2json\lib\services\PageProps;
use Notion2json\lib\services\PageBlockToIcon;
use Notion2json\lib\services\PageBlockToCoverImageSource;
use Notion2json\lib\services\PageBlockToTitle;

class PageBlockToPageProps{
    private Block $_pageBlock;

    public function __construct(Block $pageBlock){
        $this->_pageBlock = $pageBlock;
    }

    public function toPageProps(){
        $title = (new PageBlockToTitle($this->_pageBlock))->toTitle();
        $coverImage = (new PageBlockToCoverImageSource($this->_pageBlock))->toImageCover();
        $icon = (new PageBlockToIcon($this->_pageBlock))->toIcon();
        return array(
            "title"=> $title,
            "coverImage"=>$coverImage,
            "icon"=>$icon
        );
    }
}