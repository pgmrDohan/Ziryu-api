<?php
namespace Notion2json\lib\factories;
use Notion2json\lib\NotionApiPageFetcher;
use Notion2json\lib\services\NotionPageIdValidator;
use Notion2json\lib\services\PageChunkValidator;
use Notion2json\lib\services\PageRecordValidator;
use Notion2json\lib\services\HttpPostClient;

class CreateNotionApiPageFetcher{
    private $pageId;
    public function __construct(string $pageId) {
        $this->pageId = $pageId;
    }
    public function create(): NotionApiPageFetcher {
        $notionPageIdValidator = new NotionPageIdValidator();
        $pageRecordValidator = new PageRecordValidator();
        $pageChunkValidator = new PageChunkValidator();
        $httpPostClient = new HttpPostClient();
        
        return new NotionApiPageFetcher(
            $this->pageId,
            $httpPostClient,
            $notionPageIdValidator,
            $pageRecordValidator,
            $pageChunkValidator,
          );
    }
}