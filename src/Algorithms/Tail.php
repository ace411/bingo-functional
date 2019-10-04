<?php

/**
 * Tail function.
 *
 * tail :: [a, b] -> [b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const tail = 'Chemem\\Bingo\\Functional\\Algorithms\\tail';

function tail(array $values): array
{
    return array_slice($values, 1);
}
