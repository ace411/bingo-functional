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

function fill(array $list, $value, int $start, int $end): array
{
    foreach ($list as $index => $val) {
        $list[$index] = $index >= $start && $index <= $end ? $value : $val;
    }

    return $list;
}
