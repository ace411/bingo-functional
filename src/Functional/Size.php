<?php

/**
 * size
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Size.php';

use function Chemem\Bingo\Functional\Internal\_size;

const size = __NAMESPACE__ . '\\size';

/**
 * size
 * computes the size of a list
 *
 * size :: [a] -> Int
 *
 * @param object|array $list
 * @return integer
 * @example
 *
 * size(\range(1, 5))
 * => 5
 */
function size($list): int
{
  return _size($list);
}
