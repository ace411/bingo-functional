<?php

/**
 * Monadic interface for Monads
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

interface Monadic
{
  /**
   * map
   * transforms monad state via function application and approximates do syntax
   *
   * map :: Monad m => m a -> (a -> b) -> m b
   * 
   * @param callable $function The morphism used to transform the state value
   * @return Monadic
   */
  public function map(callable $function): Monadic;

  /**
   * bind
   * sequentially composes two functions in a manner akin to >>=
   *
   * bind :: Monad m => m a -> (a -> m b) -> m b
   * 
   * @param callable $function
   * @return Monadic
   */
  public function bind(callable $function): Monadic;

  /**
   * ap
   * replaces liftM and enables function application in a Monadic environment
   *
   * ap :: Monad m => m (a -> b) -> m a -> m b
   * 
   * @param Monadic
   * @return Monadic
   */
  public function ap(Monadic $app): Monadic;
}
