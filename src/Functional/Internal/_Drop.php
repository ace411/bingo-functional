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
  $listCount            = _size($list);
  ['result' => $result] = _fold(
    function (array $acc, $val, $key) use ($count, $list, $left, $listCount) {
      if ($left) {
        if (($acc['count'] + 1) <= $count) {
          if (\is_object($acc['result'])) {
            unset($acc['result']->{$key});
          } elseif (\is_array($acc['result'])) {
            unset($acc['result'][$key]);
          }
        }
      } else {
        if (($listCount - $acc['count']) <= $count) {
          if (\is_object($list)) {
            unset($acc['result']->{$key});
          } elseif (\is_array($acc['result'])) {
            unset($acc['result'][$key]);
          }
        }
      }

      $acc['count'] += 1;

      return $acc;
    },
    $list,
    [
      'result'  => $list,
      'count'   => 0,
    ]
  );

  return $result;
}
