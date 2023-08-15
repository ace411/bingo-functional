<?php

/**
 * fill function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const fill = __NAMESPACE__ . '\\fill';

/**
 * fill
 * replaces values in a specified index range with an arbitrary value
 *
 * fill :: [a] -> b -> Int -> Int -> [b]
 *
 * @param array|object $list
 * @param mixed $value
 * @param integer $start
 * @param integer $end
 * @return array|object
 * @example
 *
 * fill((object) range(4, 9), 'foo', 1, 3)
 * => object(stdClass) {4, 'foo', 'foo', 'foo', 8, 9}
 */
function fill($list, $value, int $start, int $end)
{
  return fold(
    function ($acc, $entry, $key) use ($value, $start, $end) {
      if (\is_object($acc)) {
        $acc->{$key} = $key >= $start && $key <= $end ?
          $value :
          $entry;
      } elseif (\is_array($acc)) {
        $acc[$key] = $key >= $start && $key <= $end ?
          $value :
          $entry;
      }

      return $acc;
    },
    $list,
    $list
  );
}
