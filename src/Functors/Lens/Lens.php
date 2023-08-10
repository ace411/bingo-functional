<?php

/**
 * lens
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

const lens = __NAMESPACE__ . '\\lens';

/**
 * lens
 * builds a lens out of a getter and setter
 *
 * lens :: (s -> a) -> ((a, s) -> s) -> Lens s a
 *
 * @param callable $get
 * @param callable $set
 * @return callable
 */
function lens(callable $get, callable $set): callable
{
  return function ($func) use ($get, $set) {
    return function ($list) use ($get, $set, $func) {
      return $func($get($list))
        ->map(
          function ($replacement) use ($set, $list) {
            return $set($replacement, $list);
          }
        );
    };
  };
}
