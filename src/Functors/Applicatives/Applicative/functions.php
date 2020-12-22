<?php

/**
 * Applicative helper functions.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicatives\Applicative;

use Chemem\Bingo\Functional\Functors\Applicatives\Applicative as App;
use Chemem\Bingo\Functional\Algorithms as f;

/**
 * pure function
 * Lifts a value.
 *
 * pure :: a -> f a
 *
 * @param mixed $value
 * @return Applicative
 */

const pure = 'Chemem\\Bingo\\Functional\\Functors\\Applicatives\\Applicative\\pure';

function pure($value): App
{
  return (__NAMESPACE__ . '::pure')($value);
}

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
const liftA2 = 'Chemem\\Bingo\\Functional\\Functors\\Applicatives\\Applicative\\liftA2';

function liftA2(callable $function, App ...$values): App
{
  $args = f\map(function (App $val) {
    return $val->getValue();
  }, $values);

  return pure($function(...$args));
}
