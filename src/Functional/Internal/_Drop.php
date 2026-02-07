<?php

/**
 * _drop function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_Fold.php';
require_once __DIR__ . '/_Size.php';

const _drop = __NAMESPACE__ . '\\_drop';

/**
 * _drop
 * drops elements from either the front or back of the list
 *
 * _drop :: [a, b] -> Int -> Bool -> [b]
 *
 * @internal
 * @param object|array $list
 * @param int $number
 * @param bool $left
 * @return array
 */
function _drop($list, $count, $left = true)
{
  $idx = 0;

  if ($left) {
    foreach ($list as $key => $value) {
      if (++$idx <= $count) {
        if (\is_object($list)) {
          unset($list->{$key});
        } elseif (\is_array($list)) {
          unset($list[$key]);
        }
      } else {
        break;
      }
    }
  } else {
    \end($list);

    while ($idx < $count) {
      $key = \key($list);
      if (\is_object($list)) {
        unset($list->{$key});
      } elseif (\is_array($list)) {
        unset($list[$key]);
      }

      $prev = \prev($list);

      if (!$prev) {
        \end($list);
      }

      $idx++;
    }
  }

  return $list;
}
