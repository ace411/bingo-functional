<?php

/**
 * indexesOf function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const indexesOf = __NAMESPACE__ . '\\indexesOf';

/**
 * indexesOf
 * returns all indexes that correspond to a specified list entry
 *
 * indexesOf :: [b] -> b -> [a]
 *
 * @param array|object $list
 * @param mixed $value
 * @return array
 *
 * indexesOf(['x' => 'foo', ['foo']], 'foo')
 * => ['x', 0]
 */
function indexesOf($list, $value): array
{
  return fold(function ($acc, $val, $idx) use ($value) {
    if (\is_array($val) || \is_object($val)) {
      $acc[] = indexesOf($val, $value);
    }

    if ($val == $value) {
      $acc[] = $idx;
    }

    return flatten($acc);
  }, $list, []);
}
