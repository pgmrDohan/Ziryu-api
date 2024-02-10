<?php

namespace Notion2json\errors;

class MissingContentError extends \Exception {
    public function __construct(string $pageId,$code = 0, \Exception $previous = null) {
        parent::__construct(sprintf('Can not find content on page %s. Is it empty?',$pageId), $code, $previous);
    }
}