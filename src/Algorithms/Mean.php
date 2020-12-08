<?php

/**
 * mean function.
 *
 * mean :: [a, b] -> Float c
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const mean = 'Chemem\\Bingo\\Functional\\Algorithms\\mean';

function mean($list)
{
  [$dividend, $divisor] = fold(function ($acc, $val) {
    [$div, $count] = $acc;

    return [$div + $val, $count + 1];
  }, $list, [0, 0]);

  return $dividend / $divisor;
}
