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
 * @param array|object ...$lists
 * @return array
 * @example
 *
 * zip(range(1, 3), ['foo', 'bar', 'baz'])
 * => [[1, 'foo'], [2, 'bar'], [3, 'baz']]
 */
function zip(...$lists): array
{
  return fold(
    function ($acc, $list) {
      if (\is_array($list) || \is_object($list)) {
        foreach ($list as $index => $val) {
          if (equals(indexOf($list, $val), $index)) {
            $acc[$index][] = $val;
          }
        }
      }

      return $acc;
    },
    $lists,
    []
  );
}
