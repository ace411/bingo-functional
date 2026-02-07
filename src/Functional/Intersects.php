<?php

/**
 * intersects function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const intersects = __NAMESPACE__ . '\\intersects';

/**
 * intersects
 * checks if two lists have at least one item in common
 *
 * intersects :: [a] -> [b] -> Bool
 *
 * @param array|object $first
 * @param array|object $second
 * @return boolean
 * @example
 *
 * intersects(['foo', 'bar'], range(1, 5))
 * => false
 */
function intersects($first, $second): bool
{
  $intersects = false;

  foreach ($first as $value) {
    if (has($second, $value)) {
      $intersects = true;
      break;
    }
  }

  return $intersects;
}
