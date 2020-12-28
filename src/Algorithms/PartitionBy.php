<?php

/**
 * partitionBy function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const partitionBy = __NAMESPACE__ . '\\partitionBy';

/**
 * partitionBy
 * converts array into multidimensional version with smaller arrays of defined partition size
 *
 * partitionBy :: Int -> [a] -> [[a]]
 * 
 * @param integer $partitionSize
 * @param array $list
 * @return array
 * @example
 * 
 * partitionBy(2, range(1, 6))
 * //=> [[1, 2], [3, 4], [5, 6]]
 */
function partitionBy(int $partitionSize, array $list): array
{
  if ($partitionSize == 0) {
    return $list;
  }

  $number = (int) \ceil(\count($list) / $partitionSize);

  return partition($number, $list);
}
