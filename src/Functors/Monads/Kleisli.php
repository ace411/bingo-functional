<?php

/**
 * kleisli
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Functors\Monads;

use function Chemem\Bingo\Functional\fold;

const kleisli = __NAMESPACE__ . '\\kleisli';

/**
 * kleisli
 * performs kleisli composition on functor and monadic functions
 *
 * kleisli :: (a -> m b) -> (b -> m c) -> a -> m c
 *
 * @param string $method
 * @return callable
 */
function kleisli(string $method): callable
{
  return function (callable ...$fx) use ($method) {
    return function ($obj) use ($method, $fx) {
      return fold(
        function ($x, $f) use ($method) {
          return $x->{$method}($f);
        },
        $fx,
        $obj
      );
    };
  };
}
