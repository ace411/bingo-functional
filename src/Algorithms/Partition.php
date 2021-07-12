<?php

/**
 * Partition function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const partition = __NAMESPACE__ . '\\partition';

/**
 * partition
 * converts array into multidimensional version containing an arbitrary number of sub-arrays
 *
 * partition :: Int -> [a] -> [[a]]
 *
 * @param integer $number
 * @param array $list
 * @return array
 * @example
 *
 * partition(2, range(1, 4))
 * //=> [[1, 2], [3, 4]]
 */
function partition(int $number, array $list): array
{
  $count = \count($list);
  if ($number < 2 || $count < 2) {
    return [$list];
  }

  $psize = \ceil($count / $number);

  return extend(
    [\array_slice($list, 0, $psize)],
    partition($number - 1, dropLeft($list, $psize))
  );
}
