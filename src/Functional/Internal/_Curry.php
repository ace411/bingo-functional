<?php

/**
 * _curry function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

const _curry = __NAMESPACE__ . '\\_curry';

/**
 * _curry
 * template for curry* functions
 *
 * _curry :: ((a, b) -> c) -> (Int -> ((a, b) -> c) -> a -> b -> c) -> Bool -> a -> b -> c
 *
 * @internal
 * @param callable $func
 * @param callable $curry
 * @param boolean $required
 * @return callable
 */
function _curry(
  callable $func,
  callable $curry,
  bool $required = true
): callable {
  $toCurry    = new \ReflectionFunction($func);

  $paramCount = $required ?
    $toCurry->getNumberOfRequiredParameters() :
    $toCurry->getNumberOfParameters();

  return $curry($paramCount, $func);
}
