<?php

namespace Notion2json\lib\services;
use Notion2json\lib\services\PropTitleToDecorableTexts;
use Notion2json\lib\services\FormatFilter;
use Notion2json\lib\services\PropertiesParser;
use Notion2json\lib\services\Block;

class NotionApiContentResponsesToBlocks{
    private $_notionApiContentResponses;
    public function __construct(array $notionApiContentResponses){
        $this->_notionApiContentResponses = $notionApiContentResponses;
    }

    public function toBlocks():array {
        if (!$this->_notionApiContentResponses) return [];
    
        return array_map(function($nacr):Block{
            return new Block(
                array(
                    "id"=> $nacr->id,
                    "type"=> $nacr->type,
                    "format"=> isset($nacr->format)?(new FormatFilter($nacr->format))->filter():array(),
                    "properties" => isset($nacr->format)?(new PropertiesParser($nacr->format,$nacr->properties))->parse():array(),
                    "children"=> (new NotionApiContentResponsesToBlocks($nacr->contents))->toBlocks(),
                    "decorableTexts"=> isset($nacr->properties->title) ?
                        (new PropTitleToDecorableTexts($nacr->properties->title))->toDecorableTexts()
                        :(new PropTitleToDecorableTexts($nacr->properties))->toDecorableTexts(),
                )
            );
        },$this->_notionApiContentResponses);
    }
}