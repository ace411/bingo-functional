<?php

/**
 * filter function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const filter = __NAMESPACE__ . '\\filter';

/**
 * filter
 * selects list values that conform to a boolean predicate
 *
 * filter :: (a -> Bool) -> [a] -> [a]
 *
 * @param callable $func
 * @param array|object $list
 * @return array|object
 * @example
 *
 * filter(fn ($x) => $x % 2 === 0, range(4, 8))
 * => [4, 6, 8]
 */
function filter(callable $func, $list)
{
  return fold(
    function ($acc, $val, $idx) use ($func) {
      if (!$func($val, $idx)) {
        if (\is_object($acc)) {
          unset($acc->{$idx});
        } elseif (\is_array($acc)) {
          unset($acc[$idx]);
        }
      }

      return $acc;
    },
    $list,
    $list
  );
}
