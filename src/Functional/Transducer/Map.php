<?php

/**
 * transducer-compatible map function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Transducer;

const map = __NAMESPACE__ . '\\map';

/**
 * map
 * transforms every single list entry in a single iteration; passes result to transducer
 *
 * map :: (a -> b) -> (a -> b -> c)
 *
 * @param callable $transform
 * @return callable
 */
function map(callable $transform): callable
{
  return function ($step) use ($transform) {
    return function ($acc, $val, $idx) use (
      $step,
      $transform
    ) {
      return $step($acc, $transform($val), $idx);
    };
  };
}
