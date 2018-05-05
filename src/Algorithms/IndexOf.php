<?php

namespace Chemem\Bingo\Functional\Algorithms;

const indexOf = 'Chemem\\Bingo\\Functional\\Algorithms\\indexOf';

function indexOf(array $collection, int $value, int $fromIndex = 0) : int
{
    $valKeys = array_keys($collection);
    $valCount = count($valKeys);

    $indexOf = function (int $init = 0, int $index) use (
        $value,
        $valKeys,
        $valCount, 
        &$indexOf,
        $collection
    ) {
        //keep increasing index until the right one is found
        if ($init >= $valCount) {
            return $index;
        }

        $index += $collection[$valKeys[$init]] == $value ? $init : 0;

        return $indexOf($init + 1, $index);
    };

    return $indexOf(0, $fromIndex);
}