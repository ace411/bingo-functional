<?php

/**
 * PartialRight function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_partial;

const partialRight = __NAMESPACE__ . '\\partialRight';

/**
 * partialRight
 * decomposes a function into multiple sub-functions of varying arity
 * 
 * partial :: (a, b) -> (b) a
 * 
 * @param callable $func
 * @param mixed ...$args
 * @return callable
 * @example
 * 
 * partialRight(fn ($a, $b, $c) => ($a + $b) / $c, 2)(5, 3)
 * //=> 4
 */
function partialRight(callable $func, ...$args)
{
  return _partial($func, $args, false);
}
