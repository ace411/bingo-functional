<?php

/**
 * _fold function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

const _fold = __NAMESPACE__ . '\\_fold';

/**
 * _fold
 * template for fold operation
 *
 * _fold :: (a -> b -> c -> a) -> [b] -> a -> a
 *
 * @internal
 * @param callable $func
 * @param mixed $list
 * @param mixed $acc
 * @return mixed
 */
function _fold(callable $func, $list, $acc)
{
  if (\is_array($list) || \is_object($list)) {
    foreach ($list as $idx => $val) {
      $acc = $func($acc, $val, $idx);
    }
  }

  return $acc;
}
