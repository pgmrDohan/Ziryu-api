<?php
namespace Notion2json\lib\services;
use Notion2json\lib\services\Format;

class Block{
    public string $id;
    public string $type;
    public array $children;
    public array $properties;
    public array $format;
    public array $decorableTexts;
    public function __construct(array $block) {
        $this->id = $block["id"];
        $this->type = $block["type"];
        $this->children = $block["children"];
        $this->properties = $block["properties"];
        $this->format = $block["format"];
        $this->decorableTexts = $block["decorableTexts"];
    }
}