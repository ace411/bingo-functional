<?php

/**
 * Curry function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_curry;

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
 * //=> 2
 */
function curry(callable $func, bool $required = true): callable
{
  return _curry($func, curryN, $required);
}

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
 * //=> 2
 */
function curryRight(callable $func, bool $required = true): callable
{
  return _curry($func, curryRightN, $required);
}
