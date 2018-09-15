<?php

namespace Chemem\Bingo\Functional\Functors\Monads\Reader;

use \Chemem\Bingo\Functional\Functors\Monads\Reader as ReaderMonad;

/**
 * reader :: Callable value -> Reader r a
 */

const reader = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Reader\\reader';

function reader($value) : ReaderMonad
{
    return ReaderMonad::of($value);
}

/**
 * runReader :: Reader r a -> a
 */

const runReader = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Reader\\runReader';

function runReader(ReaderMonad $reader, $value)
{
    return $reader->run($value);
}

/**
 * mapReader :: (a -> b) -> Reader r a -> a -> Reader r b
 */

const mapReader = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Reader\\mapReader';

function mapReader(callable $function, ReaderMonad $reader, $value) : ReaderMonad
{
    return reader($function($reader->run($value)));
}

/**
 * withReader :: (r -> r') -> Reader r a -> Reader r' a
 */

const withReader = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\Reader\\withReader';

function withReader(callable $function, ReaderMonad $reader) : ReaderMonad
{
    return $reader->withReader($function);
}
