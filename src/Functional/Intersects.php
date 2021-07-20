<?php

/**
 * intersects function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const intersects = __NAMESPACE__ . '\\intersects';

/**
 * intersects
 * checks if two lists have at least one item in common
 *
 * intersects :: [a] -> [b] -> Bool
 *
 * @param array|object $first
 * @param array|object $second
 * @return boolean
 * @example
 *
 * intersects(['foo', 'bar'], range(1, 5))
 * => false
 */
function intersects($first, $second): bool
{
  if (\is_object($first) && \is_object($second)) {
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
