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
    $elCount = count($collection);

    $isArrOf = function (int $init = 0, array $acc = []) use ($elCount, &$isArrOf, $collection) {
        if ($init >= $elCount) {
            $types = unique($acc);

            return count($types) == 1 ? head($types) : 'mixed';
        }

        $acc[] = gettype($collection[$init]);

        return $isArrOf($init + 1, $acc);
    };

    return !empty($collection) ? $isArrOf() : 'none';
}
