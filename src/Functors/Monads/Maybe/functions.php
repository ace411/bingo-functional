<?php

/**
 * Maybe type helper functions
 *
 * @see https://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Maybe;

use Chemem\Bingo\Functional\Functors\Monads\Just;
use Chemem\Bingo\Functional\Functors\Monads\Nothing;
use Chemem\Bingo\Functional\Functors\Monads\Monad;
use Chemem\Bingo\Functional as f;

const maybe = __NAMESPACE__ . '\\maybe';

/**
 * maybe function
 * Applies function to value inside just if Maybe value is not Nothing; default value otherwise.
 *
 * maybe :: b -> (a -> b) -> Maybe a -> b
 *
 * @param mixed $default
 * @param callable $function
 * @param Maybe $maybe
 * @return mixed
 */
function maybe($default, callable $function, Monad $maybe)
{
  return $maybe instanceof Nothing ?
    $default :
    $maybe->flatMap($function);
}

const isJust = __NAMESPACE__ . '\\isJust';

/**
 * isJust function
 * returns True if its argument is of the form Just.
 *
 * isJust :: Maybe a -> Bool
 *
 * @param Maybe $maybe
 * @return bool
 */
function isJust(Monad $maybe)
{
  return $maybe->isJust();
}

const isNothing = __NAMESPACE__ . '\\isNothing';

/**
 * isNothing function
 * returns True if its argument is of the form Nothing.
 *
 * isNothing :: Maybe a -> Bool
 *
 * @param Maybe $maybe
 * @return bool
 */
function isNothing(Monad $maybe)
{
  return $maybe->isNothing();
}

const fromJust = __NAMESPACE__ . '\\fromJust';

/**
 * fromJust function
 * extracts the element out of a Just and throws an error if its argument is Nothing.
 *
 * fromJust :: Maybe a -> a
 *
 * @param Maybe $maybe
 * @return mixed
 */
function fromJust(Monad $maybe)
{
  if ($maybe instanceof Nothing) {
    throw new \Exception('Maybe.fromJust: Nothing');
  }

  return $maybe->getJust();
}

const fromMaybe = __NAMESPACE__ . '\\fromMaybe';

/**
 * fromMaybe function
 * returns default value if maybe is Nothing; returns Just value otherwise.
 *
 * fromMaybe :: a -> Maybe a -> a
 *
 * @param mixed $default
 * @param Maybe $maybe
 * @return mixed
 */
function fromMaybe($default, Monad $maybe)
{
  return $maybe instanceof Nothing ?
    $default :
    $maybe->getJust();
}

const listToMaybe = __NAMESPACE__ . '\\listToMaybe';

/**
 * listToMaybe function
 * returns Nothing on an empty list or Just a where a is the first element of the list.
 *
 * listToMaybe :: [a] -> Maybe a
 *
 * @param array $list
 * @return Maybe
 */
function listToMaybe(array $list): Monad
{
  return empty($list) ?
    (__NAMESPACE__ . '::nothing')() :
    (__NAMESPACE__ . '::just')(f\head($list));
}


const maybeToList = __NAMESPACE__ . '\\maybeToList';

/**
 * maybeToList function
 * returns an empty list when given Nothing or a singleton list when not given Nothing.
 *
 * maybeToList :: Maybe a -> [a]
 *
 * @param Maybe $maybe
 * @return array
 */
function maybeToList(Monad $maybe): array
{
  return $maybe instanceof Nothing ? [] : [$maybe->getJust()];
}

const catMaybes = __NAMESPACE__ . '\\catMaybes';

/**
 * catMaybes function
 * takes a list of Maybes and returns a list of all the Just values.
 *
 * catMaybes :: [Maybe a] -> [a]
 *
 * @param array $maybes
 * @return array
 */
function catMaybes(array $maybes): array
{
  return f\fold(function ($list, Monad $maybe) {
    if ($maybe instanceof Just) {
      $list[] = $maybe->getJust();
    }

    return $list;
  }, $maybes, []);
}

const mapMaybe = __NAMESPACE__ . '\\mapMaybe';

/**
 * mapMaybe function
 * The mapMaybe function is a version of map which can throw out elements.
 *
 * mapMaybe :: (a -> Maybe b) -> [a] -> [b]
 *
 * @param callable $function
 * @param array $values
 * @return array
 */
function mapMaybe(callable $function, array $values): array
{
  $map = f\compose(f\partial(f\map, $function), catMaybes);

  return $map($values);
}
