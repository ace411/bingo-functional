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

function max(array $collection): float
{
    return fold(function (float $acc, float $val) {
        return $val > $acc ? $val : $acc;
    }, $collection, 0.0);
}
