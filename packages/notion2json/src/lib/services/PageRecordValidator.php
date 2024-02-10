<?php

namespace Notion2json\lib\services;
use Notion2json\errors\NotionPageAccessError;
use Notion2json\errors\MissingContentError;
use Notion2json\lib\services\HttpResponse;

class PageRecordValidator {
    public static function validate(string $notionPageId, HttpResponse $pageRecord): NotionPageAccessError | MissingContentError | null {
        $data = $pageRecord->data;
        if ($pageRecord->status == 401 || !($data->results[0]->value)){
            return new NotionPageAccessError($notionPageId);
        }

        if (!isset($data->results[0]->value->content)){
            return new MissingContentError($notionPageId);
        }

        return null;
    }
}