<?php

/**
 * transducer-compatible reject function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Transducer;

const reject = __NAMESPACE__ . '\\reject';

/**
 * reject
 * selects values that don't conform to a boolean predicate; passes result to transducer
 *
 * reject :: (a -> Bool) -> (a -> b -> c)
 *
 * @param callable $predicate
 * @return callable
 */
function reject(callable $predicate): callable
{
  return function ($step) use ($predicate) {
    return function ($acc, $val, $idx) use (
      $predicate,
      $step
    ) {
      return !$predicate($val) ?
        $step($acc, $val, $idx) :
        $acc;
    };
  };
}
