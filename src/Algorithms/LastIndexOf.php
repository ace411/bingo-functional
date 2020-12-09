<?php

/**
 * lastIndexOf function
 *
 * lastIndexOf :: Hashtable k v -> v -> k
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const lastIndexOf = __NAMESPACE__ . '\\lastIndexOf';

function lastIndexOf($list, $value, $def = null)
{
  $last = last(indexesOf($list, $value));

  return !$last ? $def : $last;
}
