<?php

/**
 * get
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const get = __NAMESPACE__ . '\\get';

/**
 * get
 * returns the state from the internals of the State monad
 *
 * get :: m s
 *
 * @return State
 */
function get(): Monad
{
  return state(
    function ($state) {
      return [$state, $state];
    }
  );
}
