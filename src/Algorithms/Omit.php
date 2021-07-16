<?php

/**
 * omit function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

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
  return _fold(function ($acc, $val, $idx) use ($keys) {
    if (\in_array($idx, $keys)) {
      if (\is_object($acc)) {
        unset($acc->{$idx});
      } elseif (\is_array($acc)) {
        unset($acc[$idx]);
      }
    }

    return $acc;
  }, $list, $list);
}
