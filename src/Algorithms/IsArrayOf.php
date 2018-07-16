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

function isArrayOf(array $collection) : string
{
    $types = [];

    foreach ($collection as $value) {
        $types[] = gettype($value);
    }

    $unique = array_unique($types);

    return count($unique) > 1 ? identity('mixed') : head($unique);
}
