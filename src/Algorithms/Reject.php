<?php

/**
 * reject function.
 *
 * reject :: (a -> Bool) -> [a] -> [a]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const reject = 'Chemem\\Bingo\\Functional\\Algorithms\\reject';

function reject(callable $func, array $collection): array
{
    $acc = [];

    foreach ($collection as $index => $value) {
        if (!$func($value)) {
            $acc[$index] = $value;
        }
    }

    return $acc;
}
