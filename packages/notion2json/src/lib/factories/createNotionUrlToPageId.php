<?php

namespace Notion2json\lib\factories;

use Notion2json\lib\NotionUrlToPageId;
use Notion2json\lib\services\IdNormalizer;
use Notion2json\lib\services\UrlValidator;

class createNotionUrlToPageId {
    private $url;
    public function __construct(string $url) {
        $this->url = $url;
    }
    public function create(): NotionUrlToPageId {
        $urlValidator = new UrlValidator();
        $idNormalizer = new IdNormalizer();
        
        return new NotionUrlToPageId($this->url, $idNormalizer, $urlValidator);
    }
}