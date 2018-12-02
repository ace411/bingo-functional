<?php

/**
 * 
 * unionWith function
 * 
 * unionWith :: (a -> b -> Bool) -> [a] -> [b] -> [a, b]
 * 
 * @see https://lodash.com/docs/4.17.11#unionWith
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const unionWith = 'Chemem\\Bingo\\Functional\\Algorithms\\unionWith';

function unionWith(callable $function, array ...$values) : array
{
    $acc = [];
    if ($function(...$values)) {
        $acc = union(...$values);
    }
    return $acc;
}