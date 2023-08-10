<?php

/**
 * runReader
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Reader.html#g:1
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Reader;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const runReader = __NAMESPACE__ . '\\runReader';

/**
 * runReader
 * runs a Reader and extracts the final value from it
 *
 * runReader :: Reader r a -> r -> a
 *
 * @param Reader $reader
 * @param mixed $value
 * @return mixed
 */
function runReader(Monad $reader, $value)
{
  return $reader->run($value);
}
