<?php

/**
 * State monad helper functions.
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use Chemem\Bingo\Functional\Functors\Monads\State as StateMonad;

/**
 * state function
 * Embed a simple state action into the monad.
 *
 * state :: (s -> (a, s)) -> m a
 *
 * @param callable $action
 *
 * @return object State
 */

const state = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\state';

function state(callable $action): StateMonad
{
    return StateMonad::of(function ($state) use ($action) {
        return $action($state);
    });
}

/**
 * put function
 * Replace the state inside the monad.
 *
 * put :: s -> m ()
 *
 * @param mixed $value
 *
 * @return object State
 */
const put = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\put';

function put($value): StateMonad
{
    return state(function ($state) use ($value) {
        return $value;
    });
}

/**
 * get function
 * Return the state from the internals of the monad.
 *
 * get :: m s
 *
 * @return object State
 */
const get = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\get';

function get(): StateMonad
{
    return state(function ($state) {
        return [$state, $state];
    });
}

/**
 * gets function
 * Gets specific component of the state, using a projection function supplied.
 *
 * gets :: MonadState s m => (s -> a) -> m a
 *
 * @param callable $projection
 *
 * @return object State
 */
function gets(callable $projection): StateMonad
{
    return state(function ($state) use ($projection) {
        return [$projection($state), $state];
    });
}

/**
 * modify function
 * Maps an old state to a new state inside a state monad.
 *
 * modify :: MonadState s m => (s -> s) -> m ()
 *
 * @param callable $function
 *
 * @return object State
 */
const modify = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\modify';

function modify(callable $function): StateMonad
{
    return StateMonad::of(function ($state) use ($function) {
        return [null, $function($state)];
    });
}

/**
 * runState function
 * Unwrap a state monad computation as a function.
 *
 * runState :: State s a -> s -> (a, s)
 *
 * @param object State $monad
 * @param mixed        $state
 *
 * @return array
 */
const runState = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\runState';

function runState(StateMonad $monad, $state): array
{
    return $monad->run($state);
}

/**
 * evalState function
 * Evaluate a state computation with the given initial state and return the final value.
 *
 * evalState :: State s a -> s -> a
 *
 * @param object State $monad
 * @param mixed        $state
 *
 * @return mixed $final
 */
const evalState = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\evalState';

function evalState(StateMonad $monad, $state)
{
    list($final) = $monad->run($state);

    return $final;
}

/**
 * execState function
 * Evaluate a state computation with the given initial state and return the final state.
 *
 * execState :: State s a -> s -> s
 *
 * @param object State $monad
 * @param mixed        $state
 *
 * @return mixed $final
 */
const execState = 'Chemem\\Bingo\\Functional\\Functors\\Monads\\State\\execState';

function execState(StateMonad $monad, $state)
{
    list(, $final) = $monad->run($state);

    return $final;
}
