<?php

/**
 * trampoline function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const trampoline = __NAMESPACE__ . '\\trampoline';

/**
 * trampoline
 * function that optimizes tail-recursion by managing recursing state
 *
 * trampoline :: (a -> (a -> b)) -> a -> b
 * 
 * @param callable $func
 * @return callable
 * @example
 * 
 * $fact = trampoline(function ($x) use (&$fact) {
 *  return $x < 2 ? 1 : $x * $fact($x - 1);
 * })(15);
 * //=> 1307674368000
 */
function trampoline(callable $func): callable
{
  $finalArgs = [];
  $recursing = false;

  return function (...$args) use ($func, $finalArgs, $recursing) {
    $finalArgs[] = $args;

    if (!$recursing) {
      $recursing = true;

      while (!empty($finalArgs)) {
        $result = $func(...\array_shift($finalArgs));
      }

      $recursing = false;
    }

    return $result;
  };
}
