<?php

/**
 * over
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

use Chemem\Bingo\Functional\Functors\IdentityFunctor;

const over = __NAMESPACE__ . '\\over';

/**
 * over
 * applies a function to the focus of a lens
 *
 * over :: (a -> f a) -> (a -> b) -> [a] -> b
 *
 * @param callable $lens
 * @param callable $operation
 * @param mixed $store
 * @return mixed
 */
function over(callable $lens, callable $operation, $store)
{
  return $lens(
    function ($res) use ($operation) {
      return IdentityFunctor::of($operation($res));
    }
  )($store)
    ->getValue();
}
