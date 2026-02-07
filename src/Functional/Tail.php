<?php

/**
 * Tail function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const tail = __NAMESPACE__ . '\\tail';

/**
 * tail
 * extracts elements after the head of a list
 *
 * tail :: [a] -> [a]
 *
 * @param array|object $list
 * @return array|object
 * @example
 *
 * tail(['foo', 'bar', 3, 9])
 * => ['bar', 3, 9]
 */
function tail($list)
{
  return dropLeft($list, 1);
}
