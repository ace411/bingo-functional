<?php

/**
 *
 * intersects function
 *
 * intersects :: [a] -> [b] -> Bool
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const intersects = 'Chemem\\Bingo\\Functional\\Algorithms\\intersects';

function intersects($first, $second): bool
{
  if (\is_object($first) && \is_object($snd)) {
    $first  = \get_object_vars($first);
    $second = \get_object_vars($second);
  }

  $fsize     = \count($first);
  $ssize     = \count($second);
  $intersect = false;

  if ($fsize > $ssize) {
    foreach ($second as $val) {
      if (\in_array($val, $first)) {
        $intersect = true;
        
        if ($intersect == true) {
          break;
        }
      }
    }
  } else {
    foreach ($first as $val) {
      if (\in_array($val, $second)) {
        $intersect = true;

        if ($intersect == true) {
          break;
        }
      }
    }
  }

  return $intersect;
}
