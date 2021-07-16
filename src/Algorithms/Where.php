<?php

/**
 * where function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const where = __NAMESPACE__ . '\\where';

/**
 * where
 * searches a multi-dimensional array using a fragment of a sub-array defined in the
 * said composite
 *
 * where :: [[a], [b]] -> [a] -> [[a]]
 *
 * @param array $list
 * @param array $search
 * @return array
 * @example
 *
 * where([
 *  ['pos' => 'pg', 'name' => 'magic'],
 *  ['pos' => 'sg', 'name' => 'jordan']
 * ], ['name' => 'jordan'])
 * => [['pos' => 'sg', 'name' => 'jordan']]
 */
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
