<?php

/**
 * Pluck function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const pluck = __NAMESPACE__ . '\\pluck';

/**
 * pluck
 * selects an item from a list by index
 *
 * pluck :: [a] -> b -> c -> b
 *
 * @param array|object $values
 * @param mixed $search
 * @param mixed $default
 * @return mixed
 *
 * pluck(['foo' => 'foo', 'bar' => 9], 'bar')
 * => 9
 */
function pluck($values, $search, $default = null)
{
  $search = \sprintf('%s', $search);

  return fold(
    function ($acc, $val, $idx) use ($search) {
      if (equals($search, \sprintf('%s', $idx))) {
        $acc = $val;
      }

      return $acc;
    },
    $values,
    $default
  );
}
