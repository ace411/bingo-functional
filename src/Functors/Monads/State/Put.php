<?php

/**
 * put
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const put = __NAMESPACE__ . '\\put';

/**
 * put
 * replaces the state inside the monad.
 *
 * put :: s -> m ()
 *
 * @param mixed $value
 * @return State
 */
function put($value): Monad
{
  return state(
    function ($state) use ($value) {
      return $value;
    }
  );
}
