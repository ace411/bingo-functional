<?php

/**
 * Partition function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Props.php';

use function Chemem\Bingo\Functional\Internal\_props;

const partition = __NAMESPACE__ . '\\partition';

/**
 * partition
 * converts array into multidimensional version containing an arbitrary number of sub-arrays
 *
 * partition :: Int -> [a] -> [[a]]
 *
 * @param integer $number
 * @param array|object $list
 * @return array
 * @example
 *
 * partition(2, range(1, 4))
 * => [[1, 2], [3, 4]]
 */
function partition(int $number, $list)
{
  $list = _props($list);

  return partitionBy(
    (int) \ceil(size($list) / $number),
    $list
  );
}
