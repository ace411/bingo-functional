<?php

/**
 * fromPairs function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const fromPairs = __NAMESPACE__ . '\\fromPairs';

/**
 * fromPairs
 * forms an associative array from discrete array pairs
 *
 * fromPairs :: [[a]] -> [a]
 *
 * @param array|object $list
 * @return array|object
 * @example
 *
 * fromPairs([['foo', 2], ['bar', 'bar']]);
 * => ['foo' => 2, 'bar' => 'bar']
 */
function fromPairs($list)
{
  return fold(
    function ($acc, $val, $key) {
      if (equals(size($val), 2)) {
        if (\is_object($acc)) {
          $acc->{head($val)} = last($val);
          unset($acc->{$key});
        } elseif (\is_array($acc)) {
          $acc[head($val)] = last($val);
          unset($acc[$key]);
        }
      }

      return $acc;
    },
    $list,
    $list
  );
}
