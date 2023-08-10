<?php

/**
 * execWriter
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Writer-Lazy.html#g:2
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Writer;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const execWriter = __NAMESPACE__ . '\\execWriter';

/**
 * execWriter
 * extracts the output from a writer computation.
 *
 * execWriter :: Writer a w -> w
 *
 * @param Writer $writer
 * @return array $output
 */
function execWriter(Monad $writer)
{
  [, $output] = $writer->run();

  return $output;
}
