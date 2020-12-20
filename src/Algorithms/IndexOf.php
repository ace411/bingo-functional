<?php

/**
 * indexOf function.
 *
 * indexOf :: [a] -> b -> c -> ([a], b, c) -> d
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const indexOf = 'Chemem\\Bingo\\Functional\\Algorithms\\indexOf';

function indexOf($list, $value, $default = null)
{
  return _fold(function ($acc, $val, $idx) use ($value) {
    if ($val === $value) {
      $acc = $idx;
    }

    return $acc;
  }, $list, $default);
}
