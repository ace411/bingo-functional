<?php

/**
 * every function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const every = __NAMESPACE__ . '\\every';

/**
 * every
 * checks if every element in a list conforms to a boolean predicate
 *
 * every :: [a] -> (a -> Bool) -> Bool
 *
 * @param array|object $list
 * @param callable $func
 * @return boolean
 * @example
 *
 * every(range(1, 9), fn ($x) => $x % 2 !== 0);
 * => false
 */
function every($list, callable $func): bool
{
  $valid = true;

  foreach ($list as $value) {
    if (equals($func($value), false)) {
      $valid = false;
      break;
    }
  }

  return $valid;
}
