<?php

/**
 * either
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Either;

use Chemem\Bingo\Functional\Functors\Monads\Left;
use Chemem\Bingo\Functional\Functors\Monads\Monad;

const either = __NAMESPACE__ . '\\either';

/**
 * either function
 * Performs case analysis for the Either type
 *
 * either :: (a -> c) -> (b -> c) -> Either a b -> c
 *
 * @param callable $left
 * @param callable $right
 * @param object Either
 * @return mixed
 */
function either(
  callable $left,
  callable $right,
  Monad $either
) {
  return $either instanceof Left ?
    $left($either->getLeft()) :
    $right($either->getRight());
}
