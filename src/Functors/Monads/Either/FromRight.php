<?php

/**
 * fromRight
 *
 * @see http://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Either.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Either;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const fromRight = __NAMESPACE__ . '\\fromRight';

/**
 * fromRight function
 * Return the contents of a Right-value or a default value otherwise.
 *
 * fromRight :: b -> Either a b -> b
 *
 * @param mixed $default
 * @param Either $either
 * @return mixed
 */
function fromRight($default, Monad $either)
{
  return \method_exists($either, 'isRight') ?
    ($either->isRight() ?? $default) :
    $default;
}
