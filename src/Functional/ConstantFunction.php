<?php

/**
 * constantFunction
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

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
 * => 'foo'
 */
function constantFunction(...$args): callable
{
  return function () use ($args) {
    return $args[0] ?? null;
  };
}
