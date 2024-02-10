<?php

namespace Notion2json\errors;

class NotionPageNotFound extends \Exception {
    public function __construct(string $pageId, $code = 0, \Exception $previous = null) {
        parent::__construct(sprintf('Can not find Notion Page of id %s. Is the url correct? It is the original page or a redirect page (not supported)?',$pageId), $code, $previous);
    }
}