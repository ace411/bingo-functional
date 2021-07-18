<?php

/**
 * transduce function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

use function Chemem\Bingo\Functional\Internal\_fold;

/**
 * transduce
 * transforms a list by pipelining list transformation functions
 *
 * transduce :: (c -> c) -> ((a, b) -> a) -> a -> [b] -> a
 *
 * @param callable $transducer
 * @param callable $iterator
 * @param array $list
 * @param mixed $acc
 * @return mixed
 */
function transduce(callable $transducer, callable $iterator, array $list, $acc)
{
  // create reducer function to be passed to fold operation
  $reducer = $transducer($iterator);

  return _fold($reducer, $list, $acc);
}
