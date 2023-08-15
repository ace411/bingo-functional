<?php

/**
 * listToMaybe
 *
 * @see https://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Maybe;

use Chemem\Bingo\Functional\Functors\Monads\Monad;

use function Chemem\Bingo\Functional\head;

const listToMaybe = __NAMESPACE__ . '\\listToMaybe';

/**
 * listToMaybe function
 * returns Nothing on an empty list or Just a where a is the first element of the list.
 *
 * listToMaybe :: [a] -> Maybe a
 *
 * @param array|object $list
 * @return Maybe
 */
function listToMaybe($list): Monad
{
  return empty($list) ?
    (__NAMESPACE__ . '::nothing')() :
    (__NAMESPACE__ . '::just')(head($list));
}
