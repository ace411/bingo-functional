<?php

/**
 * isLeft
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Either;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const isLeft = __NAMESPACE__ . '\\isLeft';

/**
 * isLeft
 * Return True if the given value is a Left-value, False otherwise.
 *
 * isLeft :: Either a b -> Bool
 *
 * @param Either $either
 * @return boolean
 */
function isLeft(Monad $either): bool
{
  return \method_exists($either, 'isLeft') ?
    $either->isLeft() :
    false;
}
