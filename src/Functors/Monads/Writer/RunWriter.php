<?php

/**
 * runWriter
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Writer-Lazy.html#g:2
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Writer;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const runWriter = __NAMESPACE__ . '\\runWriter';

/**
 * runWriter
 * Unwrap a writer computation as a (result, output) pair.
 *
 * runWriter :: Writer a w -> (a, w)
 *
 * @param Writer $writer
 * @return array
 */
function runWriter(Monad $writer): array
{
  return $writer->run();
}
