<?php

/**
 * transducer functions
 * 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms\Transducer;

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
    // add index (string or numeric) to step execution context
    return function ($acc, $val, $idx) use ($step, $transform) {
      // apply step function
      return $step($acc, $transform($val), $idx);
    };
  };
}

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
    // add index to step execution context
    return function ($acc, $val, $idx) use ($predicate, $step) {
      // check if value conforms to predicate
      // apply step function to value
      // return step function otherwise
      return $predicate($val) ? $step($acc, $val, $idx) : $acc;
    };
  };
}

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
    // add index to step execution context
    return function ($acc, $val, $idx) use ($predicate, $step) {
      // check if value doesn't conform to predicate
      // apply step function to value
      // return step function otherwise
      return !$predicate($val) ? $step($acc, $val, $idx) : $acc;
    };
  };
}
