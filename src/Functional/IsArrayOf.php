<?php

/**
 * isArrayOf function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const isArrayOf = __NAMESPACE__ . '\\isArrayOf';

/**
 * isArrayOf
 * returns the predominant array type (mixed for composite lists)
 *
 * isArrayOf :: [a] -> String
 *
 * @param array|object $list
 * @return string|null
 * @example
 *
 * isArrayOf(['foo', 'bar', 'baz'])
 * => 'string'
 */
function isArrayOf($list): ?string
{
  $cache  = [];
  $type   = null;
  $idx    = 0;

  foreach ($list as $value) {
    $tmp = \gettype($value);

    if ($idx++ > 0) {
      if (\in_array($tmp, $cache)) {
        $type = $tmp;
      } else {
        $type = 'mixed';
        break;
      }
    } else {
      $cache[]  = $tmp;
      $type     = $tmp;
    }
  }

  return $type;
}
