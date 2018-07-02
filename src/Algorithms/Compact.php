<?php

/**
 * Compact function.
 *
 * compact :: [a, Bool b] -> [a]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const compact = 'Chemem\\Bingo\\Functional\\Algorithms\\compact';

function compact(array $collection) : array
{
    return filter(
        function ($value) {
            return !is_bool($value) && !is_null($value);
        },
        $collection
    );
}
