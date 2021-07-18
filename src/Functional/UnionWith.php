<?php

/**
 * unionWith function
 *
 * @see https://lodash.com/docs/4.17.11#unionWith
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const unionWith = __NAMESPACE__ . '\\unionWith';

/**
 * unionWith
 * combines multiple arrays on fulfillment of an arbitrary condition
 *
 * unionWith :: ([a] -> [b] -> Bool) -> [a] -> [b] -> [c]
 *
 * @param callable $function
 * @param array ...$values
 * @return array
 * @example
 *
 * unionWith(
 *  fn ($x, $y) => isArrayOf($x) === isArrayOf($y),
 *  range(1, 3),
 *  range(2, 5)
 * )
 * => [1, 2, 3, 4, 5]
 */
function unionWith(callable $function, array ...$values): array
{
  $acc = [];
  if ($function(...$values)) {
    $acc = union(...$values);
  }

  return $acc;
}
