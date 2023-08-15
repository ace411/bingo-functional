<?php

/**
 * Curry function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Curry.php';

use function Chemem\Bingo\Functional\Internal\_curry;

const curry = __NAMESPACE__ . '\\curry';

/**
 * curry
 * converts an uncurried function to a curried one
 *
 * curry :: ((a, b) -> c) -> Bool -> a -> b -> c
 *
 * @param callable $func
 * @param boolean $required
 * @return callable
 * @example
 *
 * curry(fn ($x, $y) => $x / $y)(4)(2)
 * => 2
 */
function curry(callable $func, bool $required = true): callable
{
  return _curry($func, curryN, $required);
}
