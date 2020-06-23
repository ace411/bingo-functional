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

use function Chemem\Bingo\Functional\Algorithms\Internal\_anyEvery;

const every = 'Chemem\\Bingo\\Functional\\Algorithms\\every';

function every($list, callable $func): bool
{
    return count(reject($func, $list)) == 0;
}
