<?php

/**
 * fill function.
 *
 * fill :: [a] -> b -> c -> d -> ([a], b, c, d) -> [e]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const fill = 'Chemem\\Bingo\\Functional\\Algorithms\\fill';

function fill(array $collection, $value, int $start, int $end): array
{
    foreach ($collection as $index => $val) {
        $collection[$index] = $index >= $start && $index <= $end ? $value : $val;
    }

    return $collection;
}
