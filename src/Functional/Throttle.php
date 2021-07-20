<?php

/**
 * Throttle function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const throttle = __NAMESPACE__ . '\\throttle';

/**
 * throttle
 * delays function execution by a specified value
 *
 * throttle :: (a -> b) -> Int -> b
 *
 * @param callable $function
 * @param integer $timeout
 * @return callable
 * @example
 *
 * throttle(fn ($x) => $x ** 2, 5)(5)
 * => 25
 */
function throttle(callable $function, int $timeout): callable
{
  \sleep($timeout);

  return function (...$args) use ($function) {
    return $function(...$args);
  };
}
