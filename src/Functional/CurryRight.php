<?php

/**
 * curryRight
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Curry.php';

use function Chemem\Bingo\Functional\Internal\_curry;

const curryRight = __NAMESPACE__ . '\\curryRight';

/**
 * curryRight
 * curries a function from right to left
 *
 * curryRight :: ((a, b) -> c) -> Bool -> b -> a -> c
 *
 * @param callable $func
 * @param boolean $required
 * @return callable
 * @example
 *
 * curryRight(fn ($x, $y) => $x / $y)(2)(4)
 * => 2
 */
function curryRight(callable $func, bool $required = true): callable
{
  return _curry($func, curryRightN, $required);
}
