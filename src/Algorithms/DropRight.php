<?php

/**
 * DropRight function.
 *
 * dropRight :: [a, b] -> Int -> [a]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_drop;

const dropRight = 'Chemem\\Bingo\\Functional\\Algorithms\\dropRight';

function dropRight(array $collection, int $number = 1): array
{
    return _drop($collection, $number, true);
}
