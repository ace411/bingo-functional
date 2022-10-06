<?php

/**
 * last function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const last = __NAMESPACE__ . '\\last';

/**
 * last
 * Outputs the last element in a list
 *
 * last :: [a] -> a
 *
 * @param object|array $list
 * @return mixed
 * @example
 *
 * last(range(4, 7))
 * => 7
 */
function last($list)
{
  return \end($list);
}
