<?php

/**
 * lastIndexOf function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const lastIndexOf = __NAMESPACE__ . '\\lastIndexOf';

/**
 * lastIndexOf
 * computes the last index that corresponds to a specified list entry
 *
 * lastIndexOf :: [a] -> a -> b -> a
 *
 * @param array|object $list
 * @param mixed $value
 * @param mixed $def
 * @return string|integer
 * @example
 *
 * lastIndexOf([['foo' => 2, 'bar' => 'bar'], range(2, 6)], 2)
 * => 0
 */
function lastIndexOf($list, $value, $def = null)
{
  return last(indexesOf($list, $value), $def);
}
