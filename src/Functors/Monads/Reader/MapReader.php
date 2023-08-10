<?php

/**
 * mapReader
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Reader.html#g:1
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Reader;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

const mapReader = __NAMESPACE__ . '\\mapReader';

/**
 * mapReader function
 * transforms the value returned by a Reader
 *
 * mapReader :: (a -> b) -> Reader r a -> a -> Reader r b
 *
 * @param callable $function
 * @param Reader
 * @return Reader
 */
function mapReader(callable $function, Monad $reader): Monad
{
  return $reader->map($function);
}
