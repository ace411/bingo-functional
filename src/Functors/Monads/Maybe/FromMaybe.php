<?php

/**
 * fromMaybe
 *
 * @see https://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Maybe;

use Chemem\Bingo\Functional\Functors\Monads\Monad;
use Chemem\Bingo\Functional\Functors\Monads\Nothing;

const fromMaybe = __NAMESPACE__ . '\\fromMaybe';

/**
 * fromMaybe function
 * returns default value if maybe is Nothing; returns Just value otherwise.
 *
 * fromMaybe :: a -> Maybe a -> a
 *
 * @param mixed $default
 * @param Maybe $maybe
 * @return mixed
 */
function fromMaybe($default, Monad $maybe)
{
  return $maybe instanceof Nothing ?
    $default :
    $maybe->getJust();
}
