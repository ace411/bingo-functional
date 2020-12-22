<?php

/**
 * dropRight function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_drop;

const dropRight = __NAMESPACE__ . '\\dropRight';

/**
 * dropRight
 * removes elements from the back of a list
 *
 * dropRight :: [a, b] -> Int -> [b]
 * 
 * @param array $list
 * @param integer $number
 * @return array
 * @example
 * 
 * dropRight(['foo' => 'foo', 'bar' => 'bar'], 1)
 * //=> ['foo' => 'foo']
 */
function dropRight(array $list, int $number = 1): array
{
  return _drop($list, $number, true);
}
