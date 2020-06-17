<?php

/**
 * max function.
 *
 * max :: [a, b] -> b
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const max = 'Chemem\\Bingo\\Functional\\Algorithms\\max';

function max(array $list): float
{
    return fold(function (float $acc, float $val) {
        return $val > $acc ? $val : $acc;
    }, $list, 0.0);
}
