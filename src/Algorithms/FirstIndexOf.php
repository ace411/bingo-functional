<?php

/**
 * firstIndexOf function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const firstIndexOf = __NAMESPACE__ . '\\firstIndexOf';

/**
 * firstIndexOf
 * computes the first index that corresponds to a specified list entry
 * 
 * firstIndexOf :: [a] -> a -> b -> a
 *
 * @param array|object $list
 * @param mixed $value
 * @param mixed $def
 * @return string|integer
 * @example
 * 
 * firstIndexOf([['foo' => 2, 'bar' => 'bar'], ...range(2, 6)], 'bar')
 * //=> 'bar'
 */
function firstIndexOf($list, $value, $def = null)
{
  $acc = $def;

  foreach ($list as $key => $entry) {
    if ($value == $entry) {
      $acc = $key;
      if ($acc !== $def) {
        break;
      }
    }

    if (\is_object($entry) || \is_array($entry)) {
      $acc = firstIndexOf($entry, $value, $acc);
    }
  }

  return $acc;
}
