<?php

/**
 * mapDeep function.
 *
 * mapDeep :: (a -> b) -> [a] -> [b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const mapDeep = 'Chemem\\Bingo\\Functional\\Algorithms\\mapDeep';

function mapDeep(callable $func, array $collection) : array
{
    $acc = [];

    foreach ($collection as $index => $value) {
        $acc[$index] = is_array($value) ? mapDeep($func, $value) : $func($value);
    }

    return $acc;
}
