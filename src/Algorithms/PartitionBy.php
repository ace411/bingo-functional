<?php

/**
 * partitionBy function.
 *
 * partitionBy :: Int -> [a, b] -> [[a], [b]]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const partitionBy = __NAMESPACE__ . '\\partitionBy';

function partitionBy(int $partitionSize, array $list): array
{
  if ($partitionSize == 0) {
    return $list;
  }

  $number = (int) \ceil(\count($list) / $partitionSize);

  return partition($number, $list);
}
