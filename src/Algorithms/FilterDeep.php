<?php

/**
 * filterDeep function
 * 
 * filterDeep :: (a -> Bool) -> [a] -> [a]
 * 
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const filterDeep = 'Chemem\\Bingo\\Functional\\Algorithms\\filterDeep';

function filterDeep(callable $function, array $values) : array
{
    $acc = [];
    foreach ($values as $key => $value) {
        $acc[$key] = is_array($value) ? filter($function, $value) : filter($function, [$value]);
    }
    return flatten($acc);
}