<?php

/**
 * set
 *
 * @see https://ramdajs.com/docs/#lens
 * @see https://medium.com/@dtipson/functional-lenses-d1aba9e52254
 * @see https://medium.com/javascript-scene/lenses-b85976cb0534
 * @see https://hackage.haskell.org/package/data-lens-light-0.1.2.2/docs/Data-Lens-Light.html#v:lens
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Lens;

use function Chemem\Bingo\Functional\K;

const set = __NAMESPACE__ . '\\set';

/**
 * set
 * updates an entity associated with the focus of a lens
 *
 * set :: (a -> f a) -> b -> [a] -> [b]
 *
 * @param callable $lens
 * @param mixed $value
 * @param mixed $store
 * @return mixed
 */
function set(callable $lens, $value, $store)
{
  return over($lens, K($value), $store);
}
