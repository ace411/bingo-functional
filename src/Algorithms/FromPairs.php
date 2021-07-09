<?php

/**
 * fromPairs function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const fromPairs = __NAMESPACE__ . '\\fromPairs';

/**
 * fromPairs
 * forms an associative array from discrete array pairs
 *
 * fromPairs :: [[a]] -> [a]
 *
 * @param array $list
 * @return array
 * @example
 *
 * fromPairs([['foo', 2], ['bar', 'bar']]);
 * //=> ['foo' => 2, 'bar' => 'bar']
 */
function fromPairs(array $list): array
{
  return fold(function ($acc, $val) {
    if (\is_array($val) && \count($val) == 2) {
      $acc[head($val)] = last($val);
    }

    return $acc;
  }, $list, []);
}
