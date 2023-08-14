<?php

/**
 * K combinator
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

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
 * => 12
 */
function K(...$args): callable
{
  return constantFunction(...$args);
}
