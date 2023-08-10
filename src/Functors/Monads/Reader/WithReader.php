<?php

/**
 * withReader
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Reader.html#g:1
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Reader;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const withReader = __NAMESPACE__ . '\\withReader';

/**
 * withReader function
 * executes a computation in a modified environment
 *
 * withReader :: (r -> r') -> Reader r a -> Reader r' a
 *
 * @param callable $function
 * @param Reader $reader
 * @return Reader
 */
function withReader(callable $function, Monad $reader): Monad
{
  return $reader->bind($function);
}
