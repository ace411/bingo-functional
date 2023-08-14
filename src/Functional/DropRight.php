<?php

/**
 * dropRight function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Drop.php';

use function Chemem\Bingo\Functional\Internal\_drop;

const dropRight = __NAMESPACE__ . '\\dropRight';

/**
 * dropRight
 * removes elements from the back of a list
 *
 * dropRight :: [a, b] -> Int -> [b]
 *
 * @param array|object $list
 * @param integer $number
 * @return array|object
 * @example
 *
 * dropRight(['foo' => 'foo', 'bar' => 'bar'], 1)
 * => ['foo' => 'foo']
 */
function dropRight($list, int $number = 1)
{
  return _drop($list, $number, false);
}
