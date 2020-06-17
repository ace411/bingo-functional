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

use function Chemem\Bingo\Functional\Algorithms\Internal\_anyEvery;

const any = 'Chemem\\Bingo\\Functional\\Algorithms\\any';

function any($list, callable $func): bool
{
    return _anyEvery($func, $list, false);
}
