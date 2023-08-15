<?php

/**
 * fold
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Fold.php';

use function Chemem\Bingo\Functional\Internal\_fold;

const fold = __NAMESPACE__ . '\\fold';

/**
 * fold
 * transforms a list into a single value
 *
 * fold :: (a -> b -> c) -> [b] -> a -> a
 *
 * @param callable $func
 * @param array|object $list
 * @param mixed $acc
 * @return mixed
 * @example
 *
 * fold(fn ($x, $y) => $x > $y ? $x : $y, [3, 8, 2], 0)
 * => 8
 */
function fold(callable $func, $list, $acc)
{
  return _fold($func, $list, $acc);
}
