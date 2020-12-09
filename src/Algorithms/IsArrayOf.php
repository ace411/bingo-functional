<?php

/**
 * isArrayOf function.
 *
 * isArrayOf :: [a] -> String b
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const isArrayOf = 'Chemem\\Bingo\\Functional\\Algorithms\\isArrayOf';

function isArrayOf(array $list): string
{
    $types = \array_unique(map('gettype', $list));

    return \count($types) > 1 ? 'mixed' : head($types);
}
