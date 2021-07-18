<?php

/**
 * ApplicativeFunctor interface
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors;

interface ApplicativeFunctor extends Functor
{
  /**
   * ap
   * replaces liftM and enables function application in Applicative environment
   *
   * ap :: Applicative f => f (a -> b) -> f a -> f b
   *
   * @param ApplicativeFunctor
   * @return ApplicativeFunctor
   */
  public function ap(ApplicativeFunctor $applicative): ApplicativeFunctor;
}
