<?php

/**
 * partitionBy function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Props.php';

use function Chemem\Bingo\Functional\Internal\_props;

const partitionBy = __NAMESPACE__ . '\\partitionBy';

/**
 * partitionBy
 * converts array into multidimensional version with smaller arrays of defined partition size
 *
 * partitionBy :: Int -> [a] -> [[a]]
 *
 * @param integer $partitionSize
 * @param array|object $list
 * @return array
 * @example
 *
 * partitionBy(2, range(1, 6))
 * => [[1, 2], [3, 4], [5, 6]]
 */
function partitionBy(int $partitionSize, $list)
{
  $list = _props($list);

  if (equals($partitionSize, 0)) {
    return $list;
  }

  $number = (int) \ceil(size($list) / $partitionSize);

  return partition($number, $list);
}
