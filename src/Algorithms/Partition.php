<?php

/**
 * Partition function.
 *
 * partition :: Int -> [a, b] -> [[a], [b]]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const partition = 'Chemem\\Bingo\\Functional\\Algorithms\\partition';

function partition(int $number, array $list): array
{
  $count = \count($list);
  if ($number < 2 || $count < 2) {
    return [$list];
  }

  $pSize = \ceil($count / $number);

  return \array_merge(
        [\array_slice($list, 0, $pSize)],
        partition($number - 1, \array_slice($list, $pSize))
    );
}
