<?php

/**
 * flatten function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const flatten = __NAMESPACE__ . '\\flatten';

/**
 * flatten
 * reduces list dimensionality to one
 *
 * flatten :: [[a]] -> [a]
 *
 * @param array $list
 * @return array
 * @example
 *
 * flatten(['foo', range(1, 3)])
 * //=> ['foo', 1, 2, 3]
 */
function flatten(array $list): array
{
  $flattened = fold(
    function ($acc, $value) {
      return \is_array($value) ?
        extend($acc, flatten($value)) :
        extend($acc, [$value]);
    },
    $list,
    []
  );

  return $flattened;
}
