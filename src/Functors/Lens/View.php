<?php

/**
 * view
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

use Chemem\Bingo\Functional\Functors\ConstantFunctor;

const view = __NAMESPACE__ . '\\view';

/**
 * view
 * extracts the focus of a lens
 *
 * view :: (a -> f a) -> [a] -> a
 *
 * @param callable $lens
 * @param mixed $store
 * @return mixed
 */
function view(callable $lens, $store)
{
  return $lens(ConstantFunctor::of)($store)->getValue();
}
