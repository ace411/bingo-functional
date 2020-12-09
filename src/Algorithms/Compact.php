<?php

/**
 * Compact function.
 *
 * compact :: [a, Bool b] -> [a]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const compact = 'Chemem\\Bingo\\Functional\\Algorithms\\compact';

function compact($list)
{
  return filter(function ($value) {
    return $value !== false && !\is_null($value);
  }, $list);
}
