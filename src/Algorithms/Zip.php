<?php

/**
 * Zip function
 *
 * zip :: [a] -> [b] -> [(a, b)]
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const zip = "Chemem\\Bingo\\Functional\\Algorithms\\zip";

function zip(callable $fn = null, array ...$args) : array
{
    return is_null($fn) ?
        array_map(null, ...$args) :
        array_map($fn, ...$args);
}
