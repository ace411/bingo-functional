<?php

/**
 * isRight
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Either;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const isRight = __NAMESPACE__ . '\\isRight';

/**
 * isRight function
 * Return True if the given value is a Right-value, False otherwise.
 *
 * isRight :: Either a b -> Bool
 *
 * @param Either $either
 * @return bool
 */
function isRight(Monad $either): bool
{
  return \method_exists($either, 'isRight') ?
    $either->isRight() :
    false;
}
