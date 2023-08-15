<?php

/**
 * transducer-compatible filter function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Transducer;

const filter = __NAMESPACE__ . '\\filter';

/**
 * filter
 * selects values that conform to a boolean predicate; passes result to transducer
 *
 * filter :: (a -> Bool) -> (a -> b -> c)
 *
 * @param callable $predicate
 * @return callable
 */
function filter(callable $predicate): callable
{
  return function ($step) use ($predicate) {
    return function ($acc, $val, $idx) use (
      $predicate,
      $step
    ) {
      return $predicate($val) ?
        $step($acc, $val, $idx) :
        $acc;
    };
  };
}
