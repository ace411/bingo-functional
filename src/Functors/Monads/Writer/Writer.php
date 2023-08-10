<?php

/**
 * writer
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Writer-Lazy.html#g:2
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Writer;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const writer = __NAMESPACE__ . '\\writer';

/**
 * writer
 * Create a new instance of the writer monad.
 *
 * writer :: a -> w -> Writer (a, w)
 *
 * @param mixed $result
 * @param mixed $output
 * @return Writer
 */
function writer($result, $output = null): Monad
{
  return (__NAMESPACE__ . '::of')($result, $output);
}
