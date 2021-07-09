<?php

/**
 * renameKeys function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const renameKeys = __NAMESPACE__ . '\\renameKeys';

/**
 * renameKeys
 * renames list keys
 *
 * renameKeys :: [a] -> [[b]] -> [a]
 *
 * @param array|object $list
 * @param array ...$pairs
 * @return array|object
 * @example
 *
 * renameKeys(['x' => 3, 'y' => 'foo'], ['x', 0], ['y', 1])
 * //=> [3, 'foo']
 */
function renameKeys($list, array ...$pairs)
{
  return fold(function ($acc, $val) {
    [$orig, $new] = $val;

    if (\is_object($acc)) {
      if (isset($acc->{$orig})) {
        $acc->{$new} = $acc->{$orig};
        unset($acc->{$orig});
      }
    } else {
      if (\is_array($acc)) {
        if (isset($acc[$orig])) {
          $acc[$new] = $acc[$orig];
          unset($acc[$orig]);
        }
      }
    }

    return $acc;
  }, $pairs, $list);
}
