<?php

/**
 * Applicative interface
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Applicatives;

interface Applicable
{
  /**
   * ap
   * replaces liftM and enables function application in Applicative environment
   *
   * ap :: Applicative f => f (a -> b) -> f a -> f b
   *
   * @param Applicable
   * @return Applicable
   */
  public function ap(Applicable $applicative): Applicable;
}
