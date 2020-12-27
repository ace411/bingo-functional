<?php

/**
 * Applicative helper functions.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicatives\Applicative;

use Chemem\Bingo\Functional\Functors\Applicatives\Applicable;
use Chemem\Bingo\Functional\Algorithms as f;

const pure = __NAMESPACE__ . '\\pure';

/**
 * pure function
 * Lifts a value.
 *
 * pure :: a -> f a
 *
 * @param mixed $value
 * @return Applicative
 */
function pure($value): Applicable
{
  return (__NAMESPACE__ . '::pure')($value);
}

const liftA2 = __NAMESPACE__ . '\\liftA2';

/**
 * liftA2 function
 * Lift a binary function to actions.
 *
 * liftA2 :: (a -> b -> c) -> f a -> f b -> f c
 *
 * @param callable $function
 * @param Applicative $values
 * @return Applicative
 */
function liftA2(callable $function, Applicable ...$values): Applicable
{
  $args = f\map(function (Applicable $val) {
    return $val->getValue();
  }, $values);

  return pure($function(...$args));
}
