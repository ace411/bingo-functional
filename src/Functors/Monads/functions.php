<?php

/**
 * 
 * General monadic helper functions
 * 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use \Chemem\Bingo\Functional\Algorithms as A;

/**
 * 
 * mcompose function
 * Compose two monadic values from right to left
 * 
 * mcompose :: m a -> n s -> n a
 * 
 * @param callable $funcA
 * @param callable $funcB
 * @return object Monad
 */

const mcompose = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\mcompose';

function mcompose(callable $funcA, callable $funcB)
{
    return A\fold(function (callable $acc, callable $monadFn) {
        return function ($val) use ($acc, $monadFn) {
            return bind($acc, bind($monadFn, $val));
        };
    }, [$funcB], $funcA);    
}

/**
 * 
 * bind function
 * Sequentially compose two actions, passing any value produced by the first as an argument to the second
 * 
 * bind :: Monad m => m a -> (a -> m b) -> m b
 * 
 * @param callable $function
 * @param object Monad $value
 * @return object Monad
 */

const bind = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\bind';

function bind(callable $function, $value = null)
{
    return A\curry(function ($function, $value) {
        return $value->bind($function);
    })(...func_get_args());
}
