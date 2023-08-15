<?php

/**
 * countOfKey
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const countOfKey = __NAMESPACE__ . '\\countOfKey';

/**
 * countOfKey
 * computes the frequency of a list index - the number of times it
 * appears in a list
 *
 * countOfKey :: [a] -> b -> Int
 *
 * @param array|object $list
 * @param mixed $key
 * @return integer
 * @example
 *
 * countOfKey(['foo' => range(1, 3), ...range(3, 4)], 'baz')
 * => 0
 */
function countOfKey($list, $key): int
{
  return fold(
    function ($acc, $val, $idx) use ($key) {
      if (\is_array($val) || \is_object($val)) {
        $acc += countOfKey($val, $key);
      }

      $acc += \is_string($key) ?
        (equals((string) $idx, $key) ? 1 : 0) :
        (equals($idx, $key) ? 1 : 0);

      return $acc;
    },
    $list,
    0
  );
}
