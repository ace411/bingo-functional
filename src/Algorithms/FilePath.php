<?php

/**
 *
 * filePath function
 *
 * filePath :: Int -> String -> String
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const filePath = 'Chemem\\Bingo\\Functional\\Algorithms\\filePath';

function filePath(int $level, string ...$components) : string
{
    return concat('/', dirname(__DIR__, 5 + $level), ...$components);
}
