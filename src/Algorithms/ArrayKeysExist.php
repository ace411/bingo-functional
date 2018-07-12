<?php

/**
 * arrayKeysExist function.
 *
 * arrayKeysExist :: [a] b -> (b -> [a]) -> Bool c
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const arrayKeysExist = 'Chemem\\Bingo\\Functional\\Algorithms\\arrayKeysExist';

function arrayKeysExist(array $toSearch, ...$keys) : bool
{
    $keysIntersection = array_intersect(array_keys($toSearch), $keys);

    return count($keysIntersection) !== count($keys) ? identity(false) : identity(true);
}
