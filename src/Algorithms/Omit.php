<?php

/**
 * omit function.
 *
 * omit :: [a] -> b -> a[b]
 *
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const omit = 'Chemem\\Bingo\\Functional\\Algorithms\\omit';

function omit($list, ...$keys)
{
  return _fold(function ($acc, $val, $idx) use ($keys) {
    if (\in_array($idx, $keys)) {
      if (\is_object($acc)) {
        unset($acc->{$idx});
      } elseif (\is_array($acc)) {
        unset($acc[$idx]);
      }
    }

    return $acc;
  }, $list, $list);
}
