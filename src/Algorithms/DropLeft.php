<?php

/**
 * dropLeft function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_drop;

const dropLeft = __NAMESPACE__ . '\\dropLeft';

/**
 * dropLeft
 * removes elements from the front of a list
 *
 * dropLeft :: [a, b] -> Int -> [b]
 * 
 * @param array $list
 * @param integer $number
 * @return array
 * @example
 * 
 * dropLeft(['foo' => 'foo', 'bar' => 'bar'], 1)
 * //=> ['bar' => 'bar']
 */
function dropLeft(array $list, int $number = 1): array
{
  return _drop($list, $number);
}
