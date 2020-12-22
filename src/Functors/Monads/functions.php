<?php

/**
 * General monadic helper functions.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use Chemem\Bingo\Functional\Algorithms as f;

const mcompose = __NAMESPACE__ . '\\mcompose';

/**
 * mcompose
 * composes two monadic functions from right to left
 *
 * mcompose :: m a -> n s -> n a
 *
 * @param callable $fx
 * @param callable $fy
 * @return object Monad
 */
function mcompose(callable $fx, callable $fy)
{
  return f\fold(function (callable $acc, callable $mfunc) {
    return function ($val) use ($acc, $mfunc) {
      return bind($acc, bind($mfunc, $val));
    };
  }, [$fy], $fx);
}

const bind = __NAMESPACE__ . '\\bind';

/**
 * bind
 * sequentially composes two actions, passing any value produced by the first as an argument to the second
 *
 * bind :: Monad m => m a -> (a -> m b) -> m b
 *
 * @param callable $function
 * @param object Monad $value
 * @return object Monad
 */
function bind(callable $function, Monadic $value = null): Monadic
{
  return f\curry(function ($function, $value) {
    return $value->bind($function);
  })(...\func_get_args());
}

const foldM = __NAMESPACE__ . '\\foldM';

/**
 * foldM
 * analogous to fold except its result is encapsulated within a monad.
 *
 * foldM :: (a -> b -> m a) -> [b] -> c -> m b
 *
 * @param callable $function
 * @param array $list
 * @param mixed $acc
 */
function foldM(callable $function, array $list, $acc): Monadic
{
  $monad = $function($acc, f\head($list));

  $fold = function ($acc, $collection) use (&$fold, $monad, $function) {
    if (\count($collection) == 0) {
      return $monad::of($acc);
    }
    $tail = f\tail($collection);
    $head = f\head($collection);

    return $function($acc, $head)->bind(function ($result) use ($tail, $fold) {
      return $fold($result, $tail);
    });
  };

  return $fold($acc, $list);
}

const filterM = __NAMESPACE__ . '\\filterM';

/**
 * filterM
 * analogous to filter except its result is encapsulated in a monad
 *
 * filterM :: (a -> m a) -> [a] -> m [a]
 *
 * @param callable $function
 * @param array $list
 * @return Monadic
 */
function filterM(callable $function, array $list): Monadic
{
  $monad = $function(f\head($list));

  $filter = function ($collection) use (&$filter, $function, $monad) {
    if (\count($collection) == 0) {
      return $monad::of([]);
    }
    $tail = f\tail($collection);
    $head = f\head($collection);

    return $function($head)->bind(function ($result) use ($tail, $monad, $head, $filter) {
      return $filter($tail)->bind(function ($ret) use ($result, $head, $monad) {
        if ($result) {
          \array_unshift($ret, $head);
        }

        return $monad::of($ret);
      });
    });
  };

  return $filter($list);
}

const mapM = __NAMESPACE__ . '\\mapM';

/**
 * mapM
 * analogous to map except its result is encapsulated in a monad
 *
 * mapM :: (a -> m b) -> [a] -> m [b]
 *
 * @param callable $function
 * @param array $list
 * @return Monadic
 */
function mapM(callable $function, array $list): Monadic
{
  $monad  = $function(f\head($list));

  $map    = function ($collection) use (&$map, $function, $monad) {
    if (\count($collection) == 0) {
      return $monad::of([]);
    }

    $tail = f\tail($collection);
    $head = f\head($collection);

    return $function($head)->bind(function ($result) use ($tail, $monad, $head, $map) {
      return $map($tail)->bind(function ($ret) use ($result, $head, $monad) {
        \array_unshift($ret, $result);

        return $monad::of($ret);
      });
    });
  };

  return $map($list);
}
