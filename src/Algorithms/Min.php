<?php

/**
 * min function.
 *
 * min :: [a, b] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const min = 'Chemem\\Bingo\\Functional\\Algorithms\\min';

function min(array $list): float
{
    return fold(function (float $acc, float $val) {
        return $val < $acc ? $val : $acc;
    }, $list, head($list));
}
