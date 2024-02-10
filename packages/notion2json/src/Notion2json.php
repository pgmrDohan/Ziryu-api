<?php 

declare(strict_types=1);

namespace Notion2json;
use Notion2json\lib\factories\createNotionUrlToPageId;
use Notion2json\lib\factories\CreateNotionApiPageFetcher;
use Notion2json\lib\services\NotionApiContentResponsesToBlocks;
use Notion2json\lib\services\PageBlockToPageProps;

class Notion2json{
    public static function convert(string $pageUrl): object{
        $pageId = (new createNotionUrlToPageId($pageUrl))->create()->toPageId();
        $fetcher = (new CreateNotionApiPageFetcher($pageId))->create();
        $notionApiResponses = $fetcher->getNotionPageContents();
        $blocks = (new NotionApiContentResponsesToBlocks($notionApiResponses))->toBlocks();
        $pageProps = (new PageBlockToPageProps($blocks[0]))->toPageProps();
        return (object) array(
            "pageProps"=>$pageProps,
            "blocks"=>$blocks
        );
    }
}