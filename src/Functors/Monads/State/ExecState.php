<?php

/**
 * execState
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const execState = __NAMESPACE__ . '\\execState';

/**
 * execState
 * evaluates a state computation with the given initial state and return the final state.
 *
 * execState :: State s a -> s -> s
 *
 * @param State $monad
 * @param mixed $state
 * @return mixed $final
 */
function execState(Monad $monad, $state)
{
  [, $final] = $monad->run($state);

  return $final;
}
