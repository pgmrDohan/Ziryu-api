<?php

declare(strict_types=1);

namespace Notion2json\lib;

use Notion2json\lib\services\HttpPostClient;
use Notion2json\lib\services\HttpResponse;
use Notion2json\lib\services\NotionApiContentResponse;
use Notion2json\lib\services\NotionPageIdValidator;
use Notion2json\lib\services\PageRecordValidator;
use Notion2json\lib\services\PageChunkValidator;

define('NOTION_API_PATH', 'https://www.notion.so/api/v3/');

class NotionApiPageFetcher {
  public function __construct(
    private string $notionPageId,
    private HttpPostClient $httpPostClient,
    private NotionPageIdValidator $notionPageIdValidator,
    private PageRecordValidator $pageRecordValidator,
    private PageChunkValidator $pageChunkValidator
  ) {
    $pageIdError = $this->notionPageIdValidator->validate($this->notionPageId);
    if ($pageIdError) throw $pageIdError;
  }

  public function getNotionPageContents(): array {
    $pageRecords = $this->fetchRecordValues();
    $pageRecordError = $this->pageRecordValidator->validate($this->notionPageId, $pageRecords);
    if ($pageRecordError) throw $pageRecordError;

    $chunk = $this->fetchPageChunk();
    $chunkError = $this->pageChunkValidator->validate($this->notionPageId, $chunk->status);
    if ($chunkError) throw $chunkError;

    $pageData = $pageRecords->data;
    $chunkData = $chunk->data;

    $contentIds = array($pageData->results[0]->value->id);
    return $this->mapContentsIdToContent($contentIds, $chunkData, $pageData);
  }

  private function mapContentsIdToContent(
    array $contentIds,
    object $chunkData,
    object $pageData,
  ):array {
    $contentsNotInChunk = $this->contentsNotInChunk($contentIds, $chunkData, $pageData);
    $contentsInChunk = $this->contentsInChunk($contentIds, $chunkData, $pageData);
    $unorderedContents = array_filter(array_merge($contentsInChunk,$contentsNotInChunk),function($c) use ($contentIds){
      if(in_array($c->id,$contentIds)) {return $c;}
    });
    
    uasort($unorderedContents,function ($a,$b) use ($contentIds){
      array_search($a->id,$contentIds) - array_search($b->id,$contentIds);
    });

    return $unorderedContents;
  }

  private function contentsNotInChunk(
    array $contentIds,
    object $chunkData,
    object $pageData
  ): array {
    $contentsIdsNotInChunk = array_filter($contentIds, function ($id) use ($chunkData) {
      if(!isset($chunkData->recordMap->block[$id])) {return $id;}
    });
    $contentsNotInChunkRecords = $this->fetchRecordValuesByContentIds($contentsIdsNotInChunk);
    $dataNotInChunk = array_filter(array_map(function($id) use ($contentsNotInChunkRecords) {
      $data = $contentsNotInChunkRecords->data;
      return $data->recordMap->block->$id->value;
    },$contentsIdsNotInChunk),function ($d){
      if(isset($d)) {return $d;}
    });

    return array_map(function (object $c) use ($chunkData,$pageData) {
      $format = isset($c->format)?$c->format:$c;

      return (object) array(
        'id'=> $c->id,
        'type'=> $c->type,
        'properties'=>isset($c->properties) ? $c->properties:[],
        'format'=>(array)$format,
        'contents' => isset($c->content) ? 
          $this->mapContentsIdToContent($c->content, $chunkData, $pageData):
          $this->mapContentsIdToContent([], $chunkData, $pageData)
      );
    },$dataNotInChunk);
  }

  private function contentsInChunk(
    array $contentIds,
    object $chunkData,
    object $pageData
  ): array {
    $dataInChunk = array_map(function ($id) use ($chunkData) {
      return $chunkData->recordMap->block[$id]->value;
    },array_filter($contentIds, function ($id) use ($chunkData) {
      if(isset($chunkData->recordMap->block[$id])) {return $id;}
    }));

    return array_map(function (object $c) use ($chunkData,$pageData) {
      $format = $c->format;
      return (object) array(
        'id'=> $c->id,
        'type'=> $c->type,
        'properties'=>isset($c->properties) ? $c->properties:[],
        'format'=>(array)$format,
        'contents' => isset($c->content) ? 
          $this->mapContentsIdToContent($c->content, $chunkData, $pageData):
          $this->mapContentsIdToContent([], $chunkData, $pageData)
      );
    },$dataInChunk);
  }

  private function fetchRecordValues():HttpResponse {
    return $this->httpPostClient->post(NOTION_API_PATH.'getRecordValues', array(
      'requests'=> array(
        (object) array(
          'id'=>$this->notionPageId,
          'table'=>'block',
        ),
      ),
    ));
  }

  private function fetchPageChunk(): HttpResponse {
    return $this->httpPostClient->post(NOTION_API_PATH.'loadPageChunk', array(
      'pageId'=> $this->notionPageId,
      'limit'=> 100,
      'cursor'=> json_encode(array(
        'stack'=> [],
      )),
      'chunkNumber'=>0,
      'verticalColumns'=> false,
    ));
  }

  private function fetchRecordValuesByContentIds(array $contentIds): HttpResponse {
    if (count($contentIds) == 0) {
      return new HttpResponse(200, (object) array());
    }

    return $this->httpPostClient->post(NOTION_API_PATH.'syncRecordValues', array(
      'requests'=> array_map(function ($id) {
        return array(
          'id'=> $id,
          'table'=>'block',
          'version'=>-1
        );
      },$contentIds)
    ));
  }
}