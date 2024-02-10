<?php

namespace Notion2json\lib\services;

class Format{
    public string $block_color;
    public int $block_width;
    public string $page_icon;
    public string $page_cover;
    public int $page_cover_position;
    public function __construct(array $format) {
        $this->block_color = $format["block_color"];
        $this->block_width = $format["block_width"];
        $this->page_icon = $format["page_icon"];
        $this->page_cover = $format["page_cover"];
        $this->page_cover_position = $format["page_cover_position"];
    }
}