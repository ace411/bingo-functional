<?php

/**
 * Compose functions
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const compose = __NAMESPACE__ . '\\compose';

/**
 * compose
 * creates a single meta function from multiple single-arity functions
 *
 * compose :: f (g a) -> compose f g a
 *
 * @param callable ...$functions
 * @return callable
 * @example
 *
 * compose(
 *  fn ($x) => $x ** 2,
 *  fn ($x) => $x ** 3,
 * )(2);
 * => 64
 */
function compose(callable ...$functions): callable
{
  return fold(function ($id, $fn) {
    return function ($val) use ($id, $fn) {
      return $fn($id($val));
    };
  }, $functions, identity);
}

const composeRight = __NAMESPACE__ . '\\composeRight';

/**
 * composeRight
 * creates a single meta function from multiple single-arity functions
 *
 * composeRight :: g (f a) -> compose g f a
 *
 * @param callable ...$functions
 * @return callable
 * @example
 *
 * composeRight(
 *  fn ($x) => $x ** 2,
 *  fn ($x) => $x ** 3,
 * )(2);
 * => 64
 */
function composeRight(callable ...$functions): callable
{
  return flip(compose)(...$functions);
}
