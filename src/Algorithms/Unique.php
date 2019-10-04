<?php

/**
 * Unique function.
 *
 * unique :: [a, a, b] -> [a, b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const unique = 'Chemem\\Bingo\\Functional\\Algorithms\\unique';

function unique(array $collection): array
{
    $acc = [];

    foreach ($collection as $index => $value) {
        if (!in_array($value, $acc)) {
            $acc[$index] = $value;
        }
    }

    return $acc;
}
