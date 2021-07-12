<?php

/**
 * Tail function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const tail = __NAMESPACE__ . '\\tail';

/**
 * tail
 * extracts elements after the head of a list
 *
 * tail :: [a] -> [a]
 *
 * @param array|object $list
 * @return array|object
 * @example
 *
 * tail(['foo', 'bar', 3, 9])
 * //=> ['bar', 3, 9]
 */
function tail($list)
{
  [, $final] = fold(function ($acc, $val) {
    [$count, $lst] = $acc;
    $count = $count + 1;

    if ($count < 2) {
      if (\is_object($lst)) {
        unset($lst->{indexOf($lst, $val)});
      } else {
        if (\is_array($lst)) {
          unset($lst[indexOf($lst, $val)]);
        }
      }
    }

    return [$count, $lst];
  }, $list, [0, $list]);

  return $final;
}
