<?php

/**
 * Reader monad helper functions.
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-Reader.html#g:1
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Reader;

use Chemem\Bingo\Functional\Functors\Monads\Reader as ReaderMonad;

/**
 * reader function
 * The selector function to apply to the environment.
 *
 * reader :: (r -> a) -> m a
 *
 * @param mixed $value
 *
 * @return object Reader
 */

const reader = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Reader\\reader';

function reader($value): ReaderMonad
{
    return ReaderMonad::of($value);
}

/**
 * runReader function
 * Runs a Reader and extracts the final value from it.
 *
 * runReader :: Reader r a -> r -> a
 *
 * @param object Reader $reader
 * @param mixed         $value
 *
 * @return mixed
 */
const runReader = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Reader\\runReader';

function runReader(ReaderMonad $reader, $value)
{
    return $reader->run($value);
}

/**
 * mapReader function
 * Transform the value returned by a Reader.
 *
 * mapReader :: (a -> b) -> Reader r a -> a -> Reader r b
 *
 * @param callable $function
 * @param object Reader
 *
 * @return object Reader
 */
const mapReader = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Reader\\mapReader';

function mapReader(callable $function, ReaderMonad $reader): ReaderMonad
{
    return $reader->map($function);
}

/**
 * withReader function
 * Execute a computation in a modified environment.
 *
 * withReader :: (r -> r') -> Reader r a -> Reader r' a
 *
 * @param callable      $function
 * @param object Reader $reader
 *
 * @return object Reader
 */
const withReader = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Reader\\withReader';

function withReader(callable $function, ReaderMonad $reader): ReaderMonad
{
    return $reader->bind($function);
}

/**
 * ask function
 * Retrieves the monad environment.
 *
 * ask :: m r
 *
 * @return object Reader
 */
const ask = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Reader\\ask';

function ask(): ReaderMonad
{
    return ReaderMonad::of(function ($value) {
        return $value;
    });
}
