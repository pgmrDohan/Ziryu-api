<?php

namespace Notion2json\errors;

class InvalidPageUrlError extends \Exception {
    public function __construct(string $url, $code = 0, \Exception $previous = null) {
        parent::__construct(sprintf('Url "%s" is not a valid notion page.',$url), $code, $previous);
    }
}