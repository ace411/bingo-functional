<?php

/**
 * DropRight function.
 *
 * dropRight :: [a, b] Int c -> [a]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const dropRight = 'Chemem\\Bingo\\Functional\\Algorithms\\dropRight';

function dropRight(array $collection, int $number = 1, $acc = []) : array
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
        if ($init < 0) {
            return $acc;
        }

        $acc[$colKeys[$init]] = $colVals[$init];

        return $dropFn($init - 1, $acc);
    };

    return $dropFn($valCount - $number - 1);
}
