<?php

/**
 * Zip function.
 *
 * zip :: [a] -> [b] -> [(a, b)]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const zip = 'Chemem\\Bingo\\Functional\\Algorithms\\zip';

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
