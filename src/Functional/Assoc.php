<?php

/**
 * assoc function
 *
 * @see https://ramdajs.com/docs/#assoc
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

use function Chemem\Bingo\Functional\Internal\_fold;

const assoc = __NAMESPACE__ . '\\assoc';

/**
 * assoc
 * creates a shallow clone of a list with an overwritten value at a specified index
 *
 * assoc :: a -> b -> [b] -> [b]
 *
 * @param string|integer $key
 * @param mixed $val
 * @param array|object $list
 * @return array|object
 * @example
 *
 * assoc('x', 32, ['y' => 'foo', 'x' => 'bar'])
 * => ['y' => 'foo', 'x' => 32]
 */
function assoc($key, $val, $list)
{
  return _fold(function ($acc, $entry, $idx) use ($key, $val) {
    if (\is_object($acc)) {
      if ($key == $idx) {
        $acc->{$idx} = $entry;
      }

      $acc->{$key} = $val;
    } elseif (\is_array($acc)) {
      if ($key == $idx) {
        $acc[$idx] = $entry;
      }

      $acc[$key] = $val;
    }

    return $acc;
  }, $list, $list);
}
