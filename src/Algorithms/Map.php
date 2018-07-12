<?php

/**
 * map function.
 *
 * map :: (a -> b) -> [a] -> [b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const map = 'Chemem\\Bingo\\Functional\\Algorithms\\map';

function map(callable $func, array $collection) : array
{
    $acc = [];

    foreach ($collection as $index => $value) {
        $acc[$index] = $func($value);
    }

    return $acc;
}
