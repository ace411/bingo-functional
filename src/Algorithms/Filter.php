<?php

/**
 * filter function
 * 
 * filter :: (a -> Bool) -> [a] -> [a]
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const filter = "Chemem\\Bingo\\Functional\\Algorithms\\filter";

function filter(callable $func, array $collection) : array
{
    $acc = [];

    foreach ($collection as $index => $value) {
        if ($func($value)) { $acc[$index] = $value; }
    }

    return $acc;
}