<?php

namespace Notion2json\lib\services;
use Notion2json\errors\NotionPageAccessError;
use Notion2json\errors\NotionPageNotFound;

class PageChunkValidator {
    public static function validate(string $notionPageId, int $pageChunkStatus): NotionPageAccessError | NotionPageNotFound | null {
        if (in_array($pageChunkStatus,[401,403])) {
            return new NotionPageAccessError($notionPageId);
        }

        if ($pageChunkStatus == 404) {
            return new NotionPageNotFound($notionPageId);
        }

        return null;
    }
}