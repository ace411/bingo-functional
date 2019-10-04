<?php

/**
 * toPairs function.
 *
 * toPairs :: [a] -> [[b, c]]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const toPairs = 'Chemem\\Bingo\\Functional\\Algorithms\\toPairs';

function toPairs(array $collection): array
{
    $pairs = array_map(
        function ($key, $val) {
            return [$key, $val];
        },
        array_keys($collection),
        array_values($collection)
    );

    return $pairs;
}
