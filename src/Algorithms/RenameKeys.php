<?php

/**
 *
 * renameKeys function
 *
 * renameKeys :: HashTable k v -> HashTable k a -> HashTable a v
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const renameKeys = __NAMESPACE__ . '\\renameKeys';

function renameKeys($list, array ...$pairs)
{
  return fold(function ($acc, $val) {
    [$orig, $new] = $val;

    if (\is_object($acc)) {
      if (isset($acc->{$orig})) {
        $acc->{$new} = $acc->{$orig};
        unset($acc->{$orig});
      }
    } else {
      if (\is_array($acc)) {
        if (isset($acc[$orig])) {
          $acc[$new] = $acc[$orig];
          unset($acc[$orig]);
        }
      }
    }

    return $acc;
  }, $pairs, $list);
}
