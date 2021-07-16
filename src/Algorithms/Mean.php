<?php

/**
 * mean function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const mean = __NAMESPACE__ . '\\mean';

/**
 * mean
 * computes the average of items in a list
 *
 * mean :: [a] -> Float
 *
 * @param array|object $list
 * @return int|float
 * @example
 *
 * mean([9, 13, 12, 21])
 * => 13.75
 */
function mean($list)
{
  [$dividend, $divisor] = fold(function ($acc, $val) {
    [$div, $count] = $acc;

    return [$div + $val, $count + 1];
  }, $list, [0, 0]);

  return $dividend / $divisor;
}
