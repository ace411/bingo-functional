<?php

/**
 * head function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const head = __NAMESPACE__ . '\\head';

/**
 * head
 * Outputs the first element in a list
 *
 * head :: [a] -> a
 *
 * @param object|array $list
 * @return mixed
 * @example
 *
 * head(range(4, 7))
 * => 4
 */
function head($list, $def = null)
{
  return \reset($list);
}
