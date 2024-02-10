<?php
namespace Notion2json\lib\services;
class NotionApiContentResponse{
    public string $id;
    public string $type;
    public object $properties;
    public object $format;
    public NotionApiContentResponse $contents;
}