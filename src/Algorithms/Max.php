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

function max($list)
{
    return fold(function ($acc, $val) {
        return $val > $acc ? $val : $acc;
    }, $list, 0);
}
