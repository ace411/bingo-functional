<?php

/**
 * countOf* functions
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const countOfValue = __NAMESPACE__ . '\\countOfValue';

/**
 * countOfValue
 * computes the frequency of a list value - the number of times it
 * appears in a list
 *
 * countOfValue :: [a] -> a -> Int
 *
 * @param array|object $list
 * @param mixed $value
 * @return integer
 * @example
 *
 * countOfValue(['foo' => range(1, 3), ...range(3, 5)], 3)
 * //=> 2
 */
function countOfValue($list, $value): int
{
  return _fold(function ($acc, $val) use ($value) {
    if (\is_array($val) || \is_object($val)) {
      $acc += countOfValue($val, $value);
    }

    $acc += ($val == $value);

    return $acc;
  }, $list, 0);
}

const countOfKey = __NAMESPACE__ . '\\countOfKey';

/**
 * countOfKey
 * computes the frequency of a list index - the number of times it
 * appears in a list
 *
 * countOfKey :: [a] -> b -> Int
 *
 * @param array|object $list
 * @param mixed $key
 * @return integer
 * @example
 *
 * countOfKey(['foo' => range(1, 3), ...range(3, 4)], 'baz')
 * //=> 0
 */
function countOfKey($list, $key): int
{
  return _fold(function ($acc, $val, $idx) use ($key) {
    if (\is_array($val) || \is_object($val)) {
      $acc += countOfKey($val, $key);
    }

    $acc += \is_string($key) ?
      ((string) $idx == $key ? 1 : 0) :
      ($idx == $key ? 1 : 0);

    return $acc;
  }, $list, 0);
}
