<?php

namespace Notion2json\lib\services;
use Notion2json\errors\MissingPageIdError;

class NotionPageIdValidator {
    public static function validate(string ...$notionPageId): MissingPageIdError | null {
        if (!$notionPageId[0] || $notionPageId[0] == '') return new MissingPageIdError();
        return null;
    }
}