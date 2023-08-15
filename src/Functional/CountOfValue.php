<?php

/**
 * countOfValue
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const countOfValue = __NAMESPACE__ . '\\countOfValue';

/**
 * countOfValue
 * computes the frequency of a list value - the number of times it
 * appears in a list
 *
 * countOfValue :: [a] -> a -> Int
 *
 * @param array|object $list
 * @param mixed $value
 * @return integer
 * @example
 *
 * countOfValue(['foo' => range(1, 3), ...range(3, 5)], 3)
 * => 2
 */
function countOfValue($list, $value): int
{
  return fold(
    function ($acc, $val) use ($value) {
      if (\is_array($val) || \is_object($val)) {
        $acc += countOfValue($val, $value);
      }

      $acc += equals($val, $value, true);

      return $acc;
    },
    $list,
    0
  );
}
