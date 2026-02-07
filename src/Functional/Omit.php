<?php

/**
 * omit function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const omit = __NAMESPACE__ . '\\omit';

/**
 * omit
 * purges a list of values associated with specified indexes
 *
 * omit :: [a] -> b -> [a]
 *
 * @param array|object $list
 * @param string|int ...$keys
 * @return array|object
 * @example
 *
 * omit(['x' => 'x', 'y' => 'y', 'z' => 'z'], 'x', 'z')
 * => ['y' => 'y']
 */
function omit($list, ...$keys)
{
  $idx = 0;

  while (isset($keys[$idx])) {
    $key = $keys[$idx];

    if (\is_object($list)) {
      if (isset($list->{$key})) {
        unset($list->{$key});
      }
    } elseif (\is_array($list)) {
      if (isset($list[$key])) {
        unset($list[$key]);
      }
    }

    $idx++;
  }

  return $list;
}
