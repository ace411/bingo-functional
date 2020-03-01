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

const dropRight = 'Chemem\\Bingo\\Functional\\Algorithms\\dropRight';

function dropRight(array $collection, int $number = 1): array
{
    return dropT($collection, $number, true);
}
