<?php

/**
 * flip function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const flip = __NAMESPACE__ . '\\flip';

/**
 * flip
 * reverses the order of function arguments
 *
 * flip :: (a -> b -> c) -> b -> a -> c
 *
 * @param callable $function
 * @return callable
 * @example
 *
 * flip(fn ($x, $y) => $x / $y)(2, 4)
 * => 2
 */
function flip(callable $function): callable
{
  return function (...$args) use ($function) {
    return $function(...\array_reverse($args));
  };
}
