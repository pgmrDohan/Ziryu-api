<?php

namespace Notion2json\lib\services;
use Notion2json\errors\InvalidPageUrlError;

class UrlValidator {
    public static function validate(string ...$url): InvalidPageUrlError | null {
        if (!self::isNotionPargeUrl($url[0])) return new InvalidPageUrlError($url);
        return null;
    }

    private static function isNotionPargeUrl(string $url): bool {
        return preg_match('/^http(s?):\/\/((w{3}.)?notion.so|[\w\-]*\.notion\.site)\/((\w)+?\/)?(\w|-){32,}/', $url);
    }
}