<?php

namespace Notion2json\lib\services;
class IdNormalizer {
  public static function normalizeId(string $id): string {
    $isItAlreadyNormalized = mb_strlen( $id, 'utf-8' ) === 36;
    return $isItAlreadyNormalized
      ? $id
      : sprintf('%s-%s-%s-%s-%s',substr($id, 0,8),substr($id, 8,4),substr($id, 12,4),substr($id, 16,4),substr($id, 20));
  }
}