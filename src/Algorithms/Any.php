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

function any($list, callable $func): bool
{
    $result = false;
    foreach ($list as $idx => $val) {
        if ($func($val)) {
            $result = true;
            break;
        }
    }

    return $result;
}
