<?php

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use \Chemem\Bingo\Functional\Functors\Monads\State as StateMonad;

/**
 * state :: (s -> (a, s)) -> m a
 */

const state = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\state';

function state(callable $action) : StateMonad
{
    return StateMonad::of(function ($state) use ($action) {
        return $action($state);
    });
}

/**
 * put :: s -> m ()
 */

const put = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\put';

function put($value) : StateMonad
{
    return state(function ($state) use ($value) {
        return $value;
    });
}

/**
 * get :: m s
 */

const get = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\get';

function get() : StateMonad
{
    return state(function ($state) {
        return [$state, $state];
    });
}

/**
 * gets :: MonadState s m => (s -> a) -> m a
 */

function gets(callable $projection) : StateMonad
{
    return state(function ($state) use ($projection) {
        return [$projection($state), $state];
    });
}

/**
 * modify :: MonadState s m => (s -> s) -> m ()
 */

const modify = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\modify';

function modify(callable $function) : StateMonad
{
    return StateMonad::of(function ($state) use ($function) {
        return [null, $function($state)];
    });
}

/**
 * runState :: State s a -> s -> (a, s)
 */

const runState = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\runState';

function runState(StateMonad $monad, $state) : array
{
    return $monad->run($state);
}

/**
 * evalState :: State s a -> s -> a
 */

const evalState = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\evalState';

function evalState(StateMonad $monad, $state)
{
    list($initial, ) = $monad->run($state);

    return $initial;
}

/**
 * execState :: State s a -> s -> s
 */

const execState = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\execState';

function execState(StateMonad $monad, $state)
{
    list(, $final) = $monad->run($state);

    return $final;
}
