<?php

/**
 * min function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const min = __NAMESPACE__ . '\\min';

/**
 * min
 * computes the lowest value in a collection
 *
 * min :: [a] -> Int
 *
 * @param array|object $list
 * @return int|float
 * @example
 *
 * min((object) [12, 4, 6, 99, 3])
 * => 3
 */
function min($list)
{
  return fold(function ($acc, $val) {
    return $val < $acc ? $val : $acc;
  }, $list, \is_object($list) ? $list->{0} : $list[0]);
}
