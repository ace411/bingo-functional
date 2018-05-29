<?php

namespace Chemem\Bingo\Functional\Algorithms;

const max = 'Chemem\\Bingo\\Functional\\Algorithms\\max';

function max(array $collection) : int
{
    $maxVal = isArrayOf($collection) == 'integer' ? 
        fold(
            function ($acc, $val) {
                return $val > $acc ? $val : $acc;
            },
            $collection,
            0
        ) :
        0;
        
    return $maxVal;
}