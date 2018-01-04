<?php

namespace Chemem\Bingo\Functional\Algorithms;

const flatten = "Chemem\\Bingo\\Functional\\Algorithms\\flatten";

function flatten(array $collection, array $acc = []) : array
{
    $flattened = fold(
        function ($acc, $value) {
            return is_array($value) ? 
                array_merge($acc, flatten($value)) :
                array_merge($acc, [$value]);
        },
        $collection,
        $acc
    );

    return $flattened;
}

