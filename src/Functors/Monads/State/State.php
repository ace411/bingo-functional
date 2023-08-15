<?php

/**
 * state
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const state = __NAMESPACE__ . '\\state';

/**
 * state
 * embeds a simple state action into the monad
 *
 * state :: (s -> (a, s)) -> m a
 *
 * @param callable $action
 * @return State
 */
function state(callable $action): Monad
{
  return (__NAMESPACE__ . '::of')(
    function ($state) use ($action) {
      return $action($state);
    }
  );
}
