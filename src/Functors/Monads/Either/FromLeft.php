<?php

/**
 * fromLeft
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Either;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const fromLeft = __NAMESPACE__ . '\\fromLeft';

/**
 * fromLeft
 * Return the contents of a Left-value or a default value otherwise.
 *
 * fromLeft :: a -> Either a b -> a
 *
 * @param mixed $default
 * @param Either $either
 * @return mixed
 */
function fromLeft($default, Monad $either)
{
  return \method_exists($either, 'getLeft') ?
    ($either->getLeft() ?? $default) :
    $default;
}
