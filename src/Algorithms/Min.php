<?php

namespace Chemem\Bingo\Functional\Algorithms;

const min = 'Chemem\\Bingo\\Functional\\Algorithms\\min';

function min(array $collection) : int
{
    $minVal = isArrayOf($collection) == 'integer' ?
        fold(
            function ($acc, $val) {
                return $val < $acc ? $val : $acc;
            },
            $collection,
            head($collection)
        ) :
        0;

    return $minVal;
}
