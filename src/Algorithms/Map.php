<?php

/**
 * map function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const map = __NAMESPACE__ . '\\map';

/**
 * map
 * transforms every entry in a list in a single iteration
 *
 * map :: (a -> b) -> [a] -> [b]
 *
 * @param callable $func
 * @param array|object $list
 * @return array|object
 * @example
 *
 * map(fn ($x) => $x ** 2, range(4, 8));
 * //=> [16, 25, 36, 49, 64]
 */
function map(callable $func, $list)
{
  return _fold(function ($acc, $val, $idx) use ($func) {
    if (\is_object($acc)) {
      $acc->{$idx} = $func($val);
    } elseif (\is_array($acc)) {
      $acc[$idx] = $func($val);
    }

    return $acc;
  }, $list, $list);
}
