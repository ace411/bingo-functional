<?php

/**
 * Monad interface for Monads
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

interface Monad
{
  /**
   * bind
   * sequentially composes two functions in a manner akin to >>=
   *
   * bind :: Monad m => m a -> (a -> m b) -> m b
   *
   * @param callable $function
   * @return Monad
   */
  public function bind(callable $func): Monad;
}
