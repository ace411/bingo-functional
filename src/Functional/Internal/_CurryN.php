<?php

/**
 * _curryN function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_Size.php';

const _curryN = __NAMESPACE__ . '\\_curryN';

/**
 * _curryN
 * template for curryN* functions
 *
 * _curryN :: Int -> (a, (b)) -> Bool -> (b)
 *
 * @internal
 * @param int $argCount
 * @param callable $function
 * @param bool $left
 * @return callable
 */
function _curryN(
  int $argCount,
  callable $function,
  bool $left = true
): callable {
  $acc = function ($args) use (
    &$acc,
    $argCount,
    $function,
    $left
  ) {
    return function (...$inner) use (
      $argCount,
      $function,
      $args,
      $left,
      $acc
    ) {
      $final = \array_merge($args, $inner);
      if ($argCount <= _size($final)) {
        return $function(
          ...($left ? $final : \array_reverse($final))
        );
      }

      return $acc($final);
    };
  };


  return $acc([]);
}
