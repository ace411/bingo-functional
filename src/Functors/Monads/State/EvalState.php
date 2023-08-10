<?php

/**
 * evalState
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const evalState = __NAMESPACE__ . '\\evalState';

/**
 * evalState
 * evaluates a state computation with the given initial state and return the final value
 *
 * evalState :: State s a -> s -> a
 *
 * @param State $monad
 * @param mixed $state
 * @return mixed
 */
function evalState(Monad $monad, $state)
{
  [$final] = $monad->run($state);

  return $final;
}
