<?php

/**
 * any function.
 *
 * any :: [a] -> (a -> Bool) -> Bool
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const any = 'Chemem\\Bingo\\Functional\\Algorithms\\any';

function any(array $collection, callable $func): bool
{
    return filterT($collection, $func, false);
}
