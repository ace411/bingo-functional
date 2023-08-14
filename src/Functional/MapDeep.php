<?php

/**
 * mapDeep function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const mapDeep = __NAMESPACE__ . '\\mapDeep';

/**
 * mapDeep
 * transforms every entry in a list in a single iteration
 *
 * mapDeep :: (a -> b) -> [a] -> [b]
 *
 * @param callable $func
 * @param array|object $list
 * @return array|object
 * @example
 *
 * mapDeep('strtoupper', ['foo', ['bar', 'baz']])
 * => ['FOO', ['BAR', 'BAZ']]
 */
function mapDeep(callable $func, $list)
{
  return fold(
    function ($acc, $val, $idx) use ($func) {
      if (\is_object($acc)) {
        $acc->{$idx} = \is_array($val) || \is_object($val) ?
          mapDeep($func, $val) :
          $func($val);
      } elseif (\is_array($acc)) {
        $acc[$idx] = \is_array($val) || \is_object($val) ?
          mapDeep($func, $val) :
          $func($val);
      }

      return $acc;
    },
    $list,
    $list
  );
}
