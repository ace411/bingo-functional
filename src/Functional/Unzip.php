<?php

/**
 * Unzip function.
 *
 * unzip :: [(a, b)] -> ([a], [b])
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional;

const unzip = __NAMESPACE__ . '\\unzip';

/**
 * unzip
 * splits zipped array into an array containing its pre-zip constituents
 *
 * unzip :: [(a, b)] -> ([a], [b])
 *
 * @param array $zipped
 * @return array
 * @example
 *
 * unzip([[1, 'foo'], [2, 'bar']])
 * => [[1, 2], ['foo', 'bar']]
 */
function unzip(array $zipped): array
{
  return fold(
    function ($acc, $val, $idx) {
      for ($idx = 0; $idx < size($val); $idx += 1) {
        $acc[$idx][] = $val[$idx];
      }

      return $acc;
    },
    $zipped,
    []
  );
}
