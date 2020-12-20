<?php

/**
 * groupBy function.
 *
 * groupBy :: [a] -> b -> [c]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const groupBy = 'Chemem\\Bingo\\Functional\\Algorithms\\groupBy';

function groupBy(array $list, $key): array
{
  $groupFn = function (array $acc = []) use ($list, $key) {
    foreach ($list as $index => $value) {
      $acc[$value[$key]][] = isset($list[$index][$key]) ? $value : [];
    }

    return $acc;
  };

  return isArrayOf($list) == 'array' ? $groupFn() : $list;
}
