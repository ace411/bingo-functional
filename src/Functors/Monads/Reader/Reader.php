<?php

/**
 * reader
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Reader.html#g:1
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Reader;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const reader = __NAMESPACE__ . '\\reader';

/**
 * reader
 * places a selector function in the Reader monad
 *
 * reader :: (r -> a) -> m a
 *
 * @param mixed $value
 * @return Reader
 */
function reader($value): Monad
{
  return (__NAMESPACE__ . '::of')($value);
}
