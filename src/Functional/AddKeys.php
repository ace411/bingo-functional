<?php

/**
 * addKeys function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const addKeys = __NAMESPACE__ . '\\addKeys';

/**
 * addKeys
 * extracts specified keys from a list
 *
 * addKeys :: [a] -> b -> [a]
 *
 * @param array|object $list
 * @param string|int ...$keys
 * @return array|object
 * @example
 *
 * addKeys(['foo' => 2, 'bar' => 'bar'], 'foo')
 * => ['foo' => 2]
 */
function addKeys($list, ...$keys)
{
  return fold(
    function ($acc, $val, $idx) use ($keys) {
      if (!\in_array($idx, $keys)) {
        if (\is_object($acc)) {
          unset($acc->{$idx});
        } elseif (\is_array($acc)) {
          unset($acc[$idx]);
        }
      }

      return $acc;
    }, 
    $list, 
    $list
  );
}
