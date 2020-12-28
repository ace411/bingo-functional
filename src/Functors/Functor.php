<?php

/**
 * Functor interface
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors;

interface Functor
{
  /**
   * map
   * transforms Functor state via function application & approximates do syntax
   *
   * map :: Functor f => f a -> (a -> b) -> f b
   * 
   * @param callable $func
   * @return Functor
   */
  public function map(callable $func): Functor;
}
