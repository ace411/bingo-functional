<?php

/**
 * zipWith function
 *
 * @see https://lodash.com/docs/4.17.11#zipWith
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const zipWith = __NAMESPACE__ . '\\zipWith';

/**
 * zipWith
 * combines - via function - multiple lists into key-matched list groupings
 *
 * zipWith :: (a -> b -> c) -> [a] -> [b] -> [c]
 * 
 * @param callable $function
 * @param array ...$values
 * @return array
 * @example
 * 
 * zipWith(fn ($x, $y) => $x ** $y, range(1, 3), range(0, 2))
 * //=> [1, 2, 9]
 */
function zipWith(callable $function, array ...$values): array
{
  $zipped = zip(...$values);

  return (map)(function ($zip) use ($function) {
    return $function(...$zip);
  }, $zipped);
}
