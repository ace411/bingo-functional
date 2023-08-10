<?php

/**
 * tail
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\ListMonad;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const tail = __NAMESPACE__ . '\\tail';

/**
 * tail
 * extracts elements after the head of a list
 *
 * tail :: [a] -> [a]
 *
 * @param ListMonad $list
 * @return object
 */
function tail(Monad $list)
{
  // replace monoid with class containing unit type
  return new class () {
    public $value = null;
  };
}
