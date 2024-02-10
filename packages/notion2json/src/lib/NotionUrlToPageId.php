<?php 

declare(strict_types=1);

namespace Notion2json\lib;

use Notion2json\lib\services\IdNormalizer;
use Notion2json\lib\services\UrlValidator;

class NotionUrlToPageId{
    public function __construct(
        private string $url,
        private IdNormalizer $idNormalizer,
        private UrlValidator $urlValidator,
    ) {}

    public function toPageId(): string {
        $urlError = $this->urlValidator->validate($this->url);
        if ($urlError) throw $urlError;

        return $this->idNormalizer->normalizeId($this->ununormalizedPageId());
    }

    private function ununormalizedPageId(): string {
        $tail = array_reverse(explode('/',$this->url))[0];
        if (count(explode('-',$tail)) === 0) return $tail;
        
        return array_reverse(explode('-',$this->url))[0];
      }
}