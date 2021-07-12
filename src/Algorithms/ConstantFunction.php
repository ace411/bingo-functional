<?php

/**
 * constantFunction
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const constantFunction = __NAMESPACE__ . '\\constantFunction';

/**
 * constantFunction
 * returns the first argument it receives
 *
 * constantFunction :: a -> () a
 *
 * @param mixed ...$args
 * @return callable
 * @example
 *
 * constantFunction('foo', new stdClass(2.2), 3)()
 * //=> 'foo'
 */
function constantFunction(...$args): callable
{
  return function () use ($args) {
    return $args[0] ?? null;
  };
}

const K = __NAMESPACE__ . '\\K';

/**
 * K-combinator
 * manufactures a constant function
 *
 * K :: a -> b -> () a
 *
 * @param mixed ...$args
 * @return callable
 *
 * K(12, 'foo')()
 * //=> 12
 */
function K(...$args): callable
{
  return constantFunction(...$args);
}
