<?php

/**
 * gets
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const gets = __NAMESPACE__ . '\\gets';

/**
 * gets
 * gets specific component of the state, using a projection function supplied.
 *
 * gets :: MonadState s m => (s -> a) -> m a
 *
 * @param callable $projection
 *
 * @return State
 */
function gets(callable $projection): Monad
{
  return state(
    function ($state) use ($projection) {
      return [$projection($state), $state];
    }
  );
}
