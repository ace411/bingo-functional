<?php

/**
 * PartialLeft function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_partial;

const partialLeft = __NAMESPACE__ . '\\partialLeft';

/**
 * alias of partial
 * @see partial
 */
function partialLeft(callable $func, ...$args)
{
  return _partial($func, $args);
}

const partial = __NAMESPACE__ . '\\partial';

/**
 * partial
 * decomposes a function into multiple sub-functions of varying arity
 *
 * partial :: (a, b) -> (a) b
 *
 * @param callable $func
 * @param mixed ...$args
 * @return callable
 * @example
 *
 * partial(fn ($a, $b, $c) => ($a + $b) / $c, 3)(5, 2)
 * //=> 4
 */
function partial(callable $func, ...$args)
{
  return partialLeft($func, ...$args);
}
