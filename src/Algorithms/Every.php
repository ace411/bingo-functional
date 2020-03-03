<?php

/**
 * every function.
 *
 * every :: [a] -> (a -> Bool) -> Bool
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const every = 'Chemem\\Bingo\\Functional\\Algorithms\\every';

function every(array $collection, callable $func): bool
{
    return filterT($collection, $func);
}
