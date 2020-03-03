<?php

/**
 * DropLeft function.
 *
 * dropLeft :: [a, b] -> Int -> [b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const dropLeft = __NAMESPACE__ . '\\dropLeft'; // 'Chemem\\Bingo\\Functional\\Algorithms\\dropLeft';

function dropLeft(array $collection, int $number = 1): array
{
    return dropT($collection, $number);
}

const dropT = __NAMESPACE__ . '\\dropT';

/**
 * dropT function
 *
 * dropT :: Array -> Int -> Array
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */
function dropT(
    array $collection,
    int $number = 1,
    bool $left = false
): array {
    $acc        = [];
    $count      = 0;
    $toIterate  = $left ? $collection : array_reverse($collection);

    foreach ($toIterate as $idx => $val) {
        $count += 1;
        if ($count <= (count($collection) - $number)) {
            $acc[$idx] = $val;
        }
    }

    return $left ? $acc : array_reverse($acc);
}
