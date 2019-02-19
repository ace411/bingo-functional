<?php

/**
 * General monadic helper functions.
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Algorithms as A;

/**
 * mcompose function
 * Compose two monadic values from right to left.
 *
 * mcompose :: m a -> n s -> n a
 *
 * @param callable $funcA
 * @param callable $funcB
 *
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
 * bind function
 * Sequentially compose two actions, passing any value produced by the first as an argument to the second.
 *
 * bind :: Monad m => m a -> (a -> m b) -> m b
 *
 * @param callable     $function
 * @param object Monad $value
 *
 * @return object Monad
 */
const bind = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\bind';

function bind(callable $function, Monadic $value = null) : Monadic
{
    return A\curry(function ($function, $value) {
        return $value->bind($function);
    })(...func_get_args());
}

/**
 *
 * foldM function
 * Analogous to fold except its result is encapsulated within a monad.
 *
 * foldM :: (a -> b -> m a) -> [b] -> c -> m b
 *
 * @param callable $function
 * @param array $list
 * @param mixed $acc
 */
const foldM = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\foldM';

function foldM(callable $function, array $list, $acc) : Monadic
{
    $monad = $function($acc, A\head($list));

    $fold = function ($acc, $collection) use (&$fold, $monad, $function) {
        if (count($collection) == 0) {
            return $monad::of($acc);
        }
        $tail = A\tail($collection);
        $head = A\head($collection);

        return $function($acc, $head)->bind(function ($result) use ($tail, $fold) {
            return $fold($result, $tail);
        });
    };
    return $fold($acc, $list);
}

/**
 *
 * filterM function
 * Analogous to filter except its result is encapsulated in a monad
 *
 * filterM :: (a -> m a) -> [a] -> m [a]
 *
 * @param callable $function
 * @param array $list
 */
const filterM = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\filterM';

function filterM(callable $function, array $list) : Monadic
{
    $monad = $function(A\head($list));

    $filter = function ($collection) use (&$filter, $function, $monad) {
        if (count($collection) == 0) {
            return $monad::of([]);
        }
        $tail = A\tail($collection);
        $head = A\head($collection);

        return $function($head)->bind(function ($result) use ($tail, $monad, $head, $filter) {
            return $filter($tail)->bind(function ($ret) use ($result, $head, $monad) {
                if ($result) {
                    array_unshift($ret, $head);
                }
                return $monad::of($ret);
            });
        });
    };

    return $filter($list);
}
