<?php

/**
 * reject function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const reject = __NAMESPACE__ . '\\reject';

/**
 * reject
 * selects list values that do not conform to a boolean predicate
 *
 * reject :: (a -> Bool) -> [a] -> Int -> [a]
 *
 * @param callable $func
 * @param array|object $list
 * @param int $mode
 * @return array|object
 * @example
 *
 * reject(fn ($x) => $x % 2 === 0, range(4, 8))
 * => [5, 7]
 */
function reject(callable $func, $list, int $mode = 0)
{
  return fold(
    function ($acc, $val, $idx) use ($func, $mode) {
      $filter = equals($mode, ARRAY_FILTER_USE_KEY) ?
        $func($idx) :
        (
          equals($mode, ARRAY_FILTER_USE_BOTH) ?
            $func($val, $idx) :
            $func($val)
        );

      if ($filter) {
        if (\is_object($acc)) {
          unset($acc->{$idx});
        } elseif (\is_array($acc)) {
          unset($acc[$idx]);
        }
      }

      return $acc;
    },
    $list,
    $list
  );
}
