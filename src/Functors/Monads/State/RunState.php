<?php

/**
 * runState
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const runState = __NAMESPACE__ . '\\runState';

/**
 * runState
 * unwraps a state monad computation as a function
 *
 * runState :: State s a -> s -> (a, s)
 *
 * @param State $monad
 * @param mixed $state
 *
 * @return array
 */
function runState(Monad $monad, $state): array
{
  return $monad->run($state);
}
