<?php

/**
 * extend function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const extend = __NAMESPACE__ . '\\extend';

/**
 * extend
 * concatenates lists
 *
 * @param array ...$lists
 * @return array
 * @example
 *
 * extend(['foo', 'bar'], ['baz'], ['fooz'])
 * => ['foo', 'bar', 'baz', 'fooz']
 */
function extend(array ...$lists): array
{
  $ret = [];

  for ($idx = 0; $idx < \count($lists); ++$idx) {
    $list = $lists[$idx];

    foreach ($list as $key => $val) {
      if (\is_string($key)) {
        $ret[$key] = $val;
      } else {
        $ret[] = $val;
      }
    }
  }

  return $ret;
}
