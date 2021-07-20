<?php

/**
 * isArrayOf function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const isArrayOf = __NAMESPACE__ . '\\isArrayOf';

/**
 * isArrayOf
 * returns the predominant array type (mixed for composite lists)
 *
 * isArrayOf :: [a] -> String
 *
 * @param array $list
 * @return string
 * @example
 *
 * isArrayOf(['foo', 'bar', 'baz'])
 * => 'string'
 */
function isArrayOf(array $list): string
{
  $types = \array_unique((map)('gettype', $list));

  return \count($types) > 1 ? 'mixed' : head($types);
}
