<?php

/**
 * indexOf function.
 *
 * indexOf :: [a] -> b -> c -> ([a], b, c) -> d
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const indexOf = 'Chemem\\Bingo\\Functional\\Algorithms\\indexOf';

function indexOf(array $collection, $value, int $fromIndex = 0)
{
    $valKeys = array_keys($collection);
    $valCount = count($valKeys);

    $indexOf = function (int $init, int $index) use (
        $value,
        $valKeys,
        $valCount,
        &$indexOf,
        $collection
    ) {
        //keep increasing index until the right one is found
        if ($init >= $valCount) {
            return $valKeys[$index];
        }

        $index += $collection[$valKeys[$init]] == $value ? $init : 0;

        return $indexOf($init + 1, $index);
    };

    return $indexOf(0, $fromIndex);
}
