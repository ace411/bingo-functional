<?php

/**
 * Reader monad helper functions.
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
