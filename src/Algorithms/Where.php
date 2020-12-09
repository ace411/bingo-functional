<?php

/**
 * where function.
 *
 * where :: [a] -> [b] -> [c]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const where = 'Chemem\\Bingo\\Functional\\Algorithms\\where';

function where(array $list, array $search): array
{
  list($searchKey, $searchVal) = head(toPairs($search));

  $whereFn = function (array $acc = []) use ($searchKey, $searchVal, $list) {
    foreach ($list as $index => $value) {
      if (
        isset($list[$index][$searchKey]) &&
        $list[$index][$searchKey] == $searchVal
      ) {
        $acc[] = $value;
      }
    }

    return $acc;
  };

  return isArrayOf($list) == 'array' ? $whereFn() : $list;
}
