<?php

/**
 * Zip function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const zip = __NAMESPACE__ . '\\zip';

/**
 * zip
 * combines multiple lists into key-matched list groupings
 *
 * zip :: [a] -> [b] -> [(a, b)]
 *
 * @param array ...$lists
 * @return array
 * @example
 *
 * zip(range(1, 3), ['foo', 'bar', 'baz'])
 * => [[1, 'foo'], [2, 'bar'], [3, 'baz']]
 */
function zip(array ...$lists): array
{
  $acc = [];
  for ($idx = 0; $idx < \count($lists); ++$idx) {
    $list = $lists[$idx];

    foreach ($list as $index => $val) {
      if (indexOf($list, $val) == $index) {
        $acc[$index][] = $val;
      }
    }
  }

  return $acc;
}
