<?php

/**
 * _partial function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Internal;

require_once __DIR__ . '/_Merge.php';
require_once __DIR__ . '/_Size.php';

const _partial = __NAMESPACE__ . '\\_partial';

/**
 * _partial
 * template for partial* functions
 *
 * _partial :: (a -> b -> c) -> [a, b] -> Bool -> (a) b
 *
 * @internal
 * @param callable $func
 * @param array $args
 * @param bool $left
 * @return calllable
 */
function _partial(
  callable $func,
  array $args,
  bool $left = true
): callable {
  $argCount = (new \ReflectionFunction($func))
    ->getNumberOfRequiredParameters();

  $acc      = function (...$inner) use (&$acc, $func, $argCount, $left) {
    return function (...$innermost) use (
      $inner,
      $acc,
      $func,
      $left,
      $argCount
    ) {
      $final = $left ?
        _merge(false, $inner, $innermost) :
        _merge(false, \array_reverse($innermost), \array_reverse($inner));

      if ($argCount <= _size($final)) {
        return $func(...$final);
      }

      return $acc(...$final);
    };
  };

  return $acc(...$args);
}
