<?php

/**
 * mean function.
 *
 * mean :: [a, b] -> Float c
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const mean = 'Chemem\\Bingo\\Functional\\Algorithms\\mean';

function mean(array $list): float
{
    $divisor = fold(function ($acc, $val) {
        return $val + $acc;
    }, $list, 0);

    return $divisor / \count($list);
}
