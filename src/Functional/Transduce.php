<?php

/**
 * transduce function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const transduce = __NAMESPACE__ . '\\transduce';

/**
 * transduce
 * transforms a list by pipelining list transformation functions
 *
 * transduce :: (c -> c) -> ((a, b) -> a) -> a -> [b] -> a
 *
 * @param callable $transducer
 * @param callable $iterator
 * @param array|object $list
 * @param mixed $acc
 * @return mixed
 */
function transduce(
  callable $transducer,
  callable $iterator,
  $list,
  $acc
) {
  return fold($transducer($iterator), $list, $acc);
}
