<?php

/**
 * indexesOf function
 *
 * indexesOf :: Hashtable k v -> v -> [k]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const indexesOf = __NAMESPACE__ . '\\indexesOf';

function indexesOf($list, $value)
{
  return _fold(function ($acc, $val, $idx) use ($value) {
    if (\is_array($val) || \is_object($val)) {
      $acc[] = indexesOf($val, $value);
    }

    if ($val == $value) {
      $acc[] = $idx;
    }

    return flatten($acc);
  }, $list, []);
}
