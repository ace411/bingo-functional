<?php

/**
 * Applicative helper functions.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicative;

use Chemem\Bingo\Functional\Functors\ApplicativeFunctor;
use Chemem\Bingo\Functional as f;

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
function pure($value): ApplicativeFunctor
{
  return ('Chemem\\Bingo\\Functional\\Functors\\Applicative::of')($value);
}

const liftA2 = __NAMESPACE__ . '\\liftA2';

/**
 * liftA2 function
 * Lift a binary function to actions.
 *
 * liftA2 :: (a -> b -> c) -> f a -> f b -> f c
 *
 * @param callable $function
 * @param ApplicativeFunctor $values
 * @return ApplicativeFunctor
 */
function liftA2(callable $function, ApplicativeFunctor ...$values): ApplicativeFunctor
{
  $args = f\map(function (ApplicativeFunctor $val) {
    return $val->getValue();
  }, $values);

  return pure($function(...$args));
}
