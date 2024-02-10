<?php

namespace Notion2json\errors;

class MissingPageIdError extends \Exception {
    public function __construct($code = 0, \Exception $previous = null) {
        parent::__construct('MissingPageIdError', $code, $previous);
    }
}