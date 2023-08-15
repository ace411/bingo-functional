<?php

/**
 * maybe
 *
 * @see https://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Maybe;

use Chemem\Bingo\Functional\Functors\Monads\Monad;
use Chemem\Bingo\Functional\Functors\Monads\Nothing;

const maybe = __NAMESPACE__ . '\\maybe';

/**
 * maybe function
 * Applies function to value inside just if Maybe value is not Nothing; default value otherwise.
 *
 * maybe :: b -> (a -> b) -> Maybe a -> b
 *
 * @param mixed $default
 * @param callable $function
 * @param Maybe $maybe
 * @return mixed
 */
function maybe($default, callable $function, Monad $maybe)
{
  return $maybe instanceof Nothing ?
    $default :
    $maybe->flatMap($function);
}
