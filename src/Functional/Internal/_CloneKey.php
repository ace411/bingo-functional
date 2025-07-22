<?php

namespace Chemem\Bingo\Functional\Internal;

const _cloneKey = __NAMESPACE__ . '\\_cloneKey';

/**
 * _cloneKey
 * creates a singleton list from a key-value pair
 *
 * _cloneKey :: Sum Array Object -> String -> a -> Sum Array Object
 *
 * @param array|object $list
 * @param string $key
 * @param mixed $value
 * @return array|object
 */
function _cloneKey(
  $list,
  string $key,
  $value
) {
  if (\is_object($list)) {
    $new         = clone $list;
    $new->{$key} = $value;

    return $new;
  }

  $list[$key] = $value;

  return $list;
}
