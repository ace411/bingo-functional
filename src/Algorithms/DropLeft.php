<?php

/**
 * DropLeft function.
 *
 * dropLeft :: [a, b] Int c -> [b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const dropLeft = 'Chemem\\Bingo\\Functional\\Algorithms\\dropLeft';

function dropLeft(array $collection, int $number = 1, array $acc = []) : array
{
    $colVals = array_values($collection);
    $colKeys = array_keys($collection);
    $valCount = count($collection);

    $dropFn = function (int $init, array $acc = []) use (
        $colVals,
        $colKeys,
        &$dropFn,
        $valCount
    ) {
        if ($init >= $valCount) {
            return $acc;
        }

        $acc[$colKeys[$init]] = $colVals[$init];

        return $dropFn($init + 1, $acc);
    };

    return $dropFn($number);
}
