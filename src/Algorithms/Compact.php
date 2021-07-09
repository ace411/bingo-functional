<?php

/**
 * Compact function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const compact = __NAMESPACE__ . '\\compact';

/**
 * compact
 * jettisons falsy values (false, 0, NAN, and null) from a list
 *
 * compact :: [a] -> [a]
 *
 * @param array|object $list
 * @return array|object
 * @example
 *
 * compact([0, 1, 3, 'foo', NAN, 'baz', false, null])
 * //=> [1, 3, 'foo', 'baz']
 */
function compact($list)
{
  return (filter)(function ($value) {
    return $value !== false &&
      !\is_null($value) &&
      $value !== 0 &&
      $value !== NAN;
  }, $list);
}
