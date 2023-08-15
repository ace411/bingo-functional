<?php

/**
 * pure
 *
 * @see https://hackage.haskell.org/package/rio-0.1.22.0/docs/RIO-Prelude.html#v:pure
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicative;

use Chemem\Bingo\Functional\Functors\ApplicativeFunctor;

const pure = __NAMESPACE__ . '\\pure';

/**
 * pure
 * lifts a value
 *
 * pure :: a -> f a
 *
 * @param mixed $value
 * @return Applicative
 */
function pure($value): ApplicativeFunctor
{
  return (__NAMESPACE__ . '::of')($value);
}
