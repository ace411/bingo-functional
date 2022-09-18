<?php

namespace Chemem\Bingo\Functional;

const page = __NAMESPACE__ . '\\page';

/**
 * page
 * outputs the first and last elements in a specified range
 *
 * page :: Int -> Int -> Array
 *
 * @param integer $range
 * @param integer $start
 * @return array
 * @example
 *
 * page(5, 2)
 * => [5, 9]
 */
function page(int $range, int $start = 1): array
{
  $upper = ($start * $range) - 1;
  $lower = ($upper - $range) + 1;

  return [$lower, $upper];
}
