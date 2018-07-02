<?php

/**
 * groupBy function.
 *
 * groupBy :: [a] -> b -> [c]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const groupBy = 'Chemem\\Bingo\\Functional\\Algorithms\\groupBy';

function groupBy(array $collection, $key) : array
{
    $arrCount = count($collection);

    $groupFn = function (int $init = 0, array $acc = []) use (
        $key,
        $arrCount,
        &$groupFn,
        $collection
    ) {
        if ($init >= $arrCount) {
            return $acc;
        }

        $acc[$collection[$init][$key]][] = isset($collection[$init][$key]) ?
            $collection[$init] :
            [];

        return $groupFn($init + 1, $acc);
    };

    return isArrayOf($collection) == 'array' ? $groupFn() : $collection;
}
