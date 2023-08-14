<?php

/**
 * Compact function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

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
 * => [1, 3, 'foo', 'baz']
 */
function compact($list)
{
  return filter(
    function ($value) {
      return !equals($value, false) &&
        !\is_null($value) &&
        !equals($value, 0) &&
        !equals($value, NAN);
    },
    $list
  );
}
