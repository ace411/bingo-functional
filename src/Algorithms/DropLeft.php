<?php

/**
 * DropLeft function.
 *
 * dropLeft :: [a, b] -> Int -> [b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_drop;

const dropLeft = __NAMESPACE__ . '\\dropLeft';

function dropLeft(array $list, int $number = 1): array
{
  return _drop($list, $number);
}
