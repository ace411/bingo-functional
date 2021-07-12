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
use Chemem\Bingo\Functional\Functors\Monads\DoN\Parser;

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
 * sequentially composes two actions, passing any value produced by the first 
 * as an argument to the second
 *
 * bind :: Monad m => m a -> (a -> m b) -> m b
 *
 * @param callable $function
 * @param object Monad $value
 * @return object Monad
 */
function bind(callable $function, Monad $value = null): Monad
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
function foldM(callable $function, array $list, $acc): Monad
{
  $monad = $function($acc, f\head($list));

  $fold = function ($acc, $collection) use (&$fold, $monad, $function) {
    if (\count($collection) == 0) {
      return $monad::of($acc);
    }
    $tail = f\tail($collection);
    $head = f\head($collection);

    return bind(
      function ($result) use ($tail, $fold) {
        return $fold($result, $tail);
      },
      $function($acc, $head)
    );
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
 * @return Monad
 */
function filterM(callable $function, array $list): Monad
{
  $monad = $function(f\head($list));

  $filter = function ($collection) use (&$filter, $function, $monad) {
    if (\count($collection) == 0) {
      return $monad::of([]);
    }
    $tail = f\tail($collection);
    $head = f\head($collection);

    return bind(
      function ($result) use ($tail, $monad, $head, $filter) {
        return bind(
          function ($ret) use ($result, $head, $monad) {
            if ($result) {
              \array_unshift($ret, $head);
            }

            return $monad::of($ret);
          },
          $filter($tail)
        );
      },
      $function($head)
    );
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
 * @return Monad
 */
function mapM(callable $function, array $list): Monad
{
  $monad  = $function(f\head($list));

  $map    = function ($collection) use (&$map, $function, $monad) {
    if (\count($collection) == 0) {
      return $monad::of([]);
    }

    $tail = f\tail($collection);
    $head = f\head($collection);

    return bind(
      function ($result) use ($map, $tail, $head, $monad) {
        return bind(
          function ($ret) use ($head, $result, $monad) {
            \array_unshift($ret, $result);

            return $monad::of($ret);
          },
          $map($tail)
        );
      },
      $function($head)
    );
  };

  return $map($list);
}

const liftM = __NAMESPACE__ . '\\liftM';

/**
 * liftM
 * promotes a function to a monad
 * 
 * liftM :: Monad m => (a -> r) -> m a -> m r
 *
 * @param callable $function
 * @param Monad ...$args
 * @return Monad
 */
function liftM(callable $function, Monad ...$args): Monad
{
  return f\fold(
    function ($monad, $arg) {
      return $monad->ap($arg);
    },
    $args,
    f\head($args)::of(f\curry($function))
  );
}

const let = __NAMESPACE__ . '\\let';

/**
 * let
 * places object entry in Do Notation parser context
 * 
 * let :: String -> m a -> (m a -> p [m a])
 * 
 * @param string $var
 * @param object $entry
 * @return callable
 */
function let(string $var, $entry): callable
{
  return function (Parser $parser) use ($var, $entry) {
    return $parser->assign(
      $var,
      // pass parser instance onto the next function (useful for storing 'in' calls)
      // return the operand - a monad object - otherwise
      \is_callable($entry) ? $entry($parser) : $entry,
    );
  };
}

const in = __NAMESPACE__ . '\\in';

/**
 * in
 * unwraps computation in do-notation parser context
 * 
 * in :: Array -> (a -> m b) -> m b
 *
 * @param string $args
 * @param callable $action
 * @return callable
 */
function in(array $args, callable $action): callable
{
  return function (Parser $parser) use ($args, $action) {
    // pass parser instance onto the next extraction
    return $parser->extract($args, $action);
  };
}

const doN = __NAMESPACE__ . '\\doN';

/**
 * doN
 * creates pipeline for performing monad actions
 * 
 * doN :: (a -> m b) -> m b
 *
 * @param callable ...$args
 * @return Monad
 */
function doN(callable ...$args)
{
  return f\fold(
    function (Parser $parser, $arg) {
      return $arg($parser);
    },
    $args,
    new Parser
  );
}
