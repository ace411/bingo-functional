<?php

/**
 * bind
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function Chemem\Bingo\Functional\curry;

const bind = __NAMESPACE__ . '\\bind';

/**
 * bind
 * sequentially composes two actions, passing any value produced by the first
 * as an argument to the second
 *
 * bind :: Monad m => m a -> (a -> m b) -> m b
 *
 * @param callable $function
 * @param object Monad|null $value
 * @return object Monad
 */
function bind(callable $function, ?Monad $value = null): Monad
{
  return curry(
    function ($function, $value) {
      return $value->bind($function);
    }
  )(...\func_get_args());
}
