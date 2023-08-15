<?php

/**
 * mapMaybe
 *
 * @see https://hackage.haskell.org/package/base-4.11.1.0/docs/Data-Maybe.html
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads\Maybe;

use function Chemem\Bingo\Functional\compose;
use function Chemem\Bingo\Functional\partial;

use const Chemem\Bingo\Functional\map;

const mapMaybe = __NAMESPACE__ . '\\mapMaybe';

/**
 * mapMaybe function
 * The mapMaybe function is a version of map which can throw out elements.
 *
 * mapMaybe :: (a -> Maybe b) -> [a] -> [b]
 *
 * @param callable $function
 * @param array|object $values
 * @return array|object
 */
function mapMaybe(callable $function, $values)
{
  return compose(partial(map, $function), catMaybes)($values);
}
