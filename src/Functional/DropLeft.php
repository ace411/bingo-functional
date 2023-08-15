<?php

/**
 * dropLeft function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Drop.php';

use function Chemem\Bingo\Functional\Internal\_drop;

const dropLeft = __NAMESPACE__ . '\\dropLeft';

/**
 * dropLeft
 * removes elements from the front of a list
 *
 * dropLeft :: [a, b] -> Int -> [b]
 *
 * @param array|object $list
 * @param integer $number
 * @return array|object
 * @example
 *
 * dropLeft(['foo' => 'foo', 'bar' => 'bar'], 1)
 * => ['bar' => 'bar']
 */
function dropLeft($list, int $number = 1)
{
  return _drop($list, $number);
}
