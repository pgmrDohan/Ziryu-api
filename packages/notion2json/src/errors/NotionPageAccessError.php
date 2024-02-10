<?php

namespace Notion2json\errors;

class NotionPageAccessError extends \Exception {
    public function __construct(string $pageId, $code = 0, \Exception $previous = null) {
        parent::__construct(sprintf('Can not read Notion Page of id %s. Is it open for public reading?',$pageId), $code, $previous);
    }
}