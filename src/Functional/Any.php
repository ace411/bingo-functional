<?php

/**
 * any function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const any = __NAMESPACE__ . '\\any';

/**
 * any
 * checks if any list entry conforms to a boolean predicate
 *
 * any :: [a] -> (a -> Bool) -> Bool
 *
 * @param array|object $list
 * @param callable $func
 * @return boolean
 * @example
 *
 * any((object) range(1, 5), fn ($x) => $x % 2 != 0)
 * => true
 */
function any($list, callable $func): bool
{
  $result = false;
  foreach ($list as $idx => $val) {
    if ($func($val)) {
      $result = true;

      break;
    }
  }

  return $result;
}
