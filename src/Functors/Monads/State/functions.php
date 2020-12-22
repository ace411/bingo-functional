<?php

/**
 * State monad helper functions.
 *
 * @see http://hackage.haskell.org/package/mtl-2.2.2/docs/Control-Monad-State-Lazy.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\State;

use Chemem\Bingo\Functional\Functors\Monads\Monadic;

const state = __NAMESPACE__ . '\\state';

/**
 * state
 * embeds a simple state action into the monad
 *
 * state :: (s -> (a, s)) -> m a
 *
 * @param callable $action
 * @return State
 */
function state(callable $action): Monadic
{
  return (__NAMESPACE__ . '::of')(
    function ($state) use ($action) {
      return $action($state);
    }
  );
}

const put = __NAMESPACE__ . '\\put';

/**
 * put
 * replaces the state inside the monad.
 *
 * put :: s -> m ()
 *
 * @param mixed $value
 * @return State
 */
function put($value): Monadic
{
  return state(function ($state) use ($value) {
    return $value;
  });
}

const get = __NAMESPACE__ . '\\get';

/**
 * get
 * returns the state from the internals of the State monad
 *
 * get :: m s
 *
 * @return State
 */
function get(): Monadic
{
  return state(function ($state) {
    return [$state, $state];
  });
}

const gets = __NAMESPACE__ . '\\gets';

/**
 * gets
 * gets specific component of the state, using a projection function supplied.
 *
 * gets :: MonadState s m => (s -> a) -> m a
 *
 * @param callable $projection
 *
 * @return State
 */
function gets(callable $projection): Monadic
{
  return state(function ($state) use ($projection) {
    return [$projection($state), $state];
  });
}

const modify = __NAMESPACE__ . '\\modify';

/**
 * modify
 * Maps an old state to a new state inside a state monad.
 *
 * modify :: MonadState s m => (s -> s) -> m ()
 *
 * @param callable $function
 * @return State
 */
function modify(callable $function): Monadic
{
  return (__NAMESPACE__ . '::of')(
    function ($state) use ($function) {
      return [null, $function($state)];
    }
  );
}

const runState = __NAMESPACE__ . '\\runState';

/**
 * runState
 * unwraps a state monad computation as a function
 *
 * runState :: State s a -> s -> (a, s)
 *
 * @param State $monad
 * @param mixed $state
 *
 * @return array
 */
function runState(Monadic $monad, $state): array
{
  return $monad->run($state);
}

const evalState = __NAMESPACE__ . '\\evalState';

/**
 * evalState
 * evaluates a state computation with the given initial state and return the final value
 *
 * evalState :: State s a -> s -> a
 *
 * @param State $monad
 * @param mixed $state
 * @return mixed
 */
function evalState(Monadic $monad, $state)
{
  [$final] = $monad->run($state);

  return $final;
}

const execState = __NAMESPACE__ . '\\execState';

/**
 * execState
 * evaluates a state computation with the given initial state and return the final state.
 *
 * execState :: State s a -> s -> s
 *
 * @param State $monad
 * @param mixed $state
 * @return mixed $final
 */
function execState(Monadic $monad, $state)
{
  [, $final] = $monad->run($state);

  return $final;
}
