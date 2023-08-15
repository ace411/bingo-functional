<?php

/**
 * modify
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const modify = __NAMESPACE__ . '\\modify';

/**
 * modify
 * Maps an old state to a new state inside a state monad.
 *
 * modify :: MonadState s m => (s -> s) -> m ()
 *
 * @param callable $function
 * @return State
 */
function modify(callable $function): Monad
{
  return (__NAMESPACE__ . '::of')(
    function ($state) use ($function) {
      return [null, $function($state)];
    }
  );
}
