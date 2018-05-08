<?php

namespace Chemem\Bingo\Functional\Algorithms;

const toPairs = 'Chemem\\Bingo\\Functional\\Algorithms\\toPairs';

function toPairs(array $collection) : array
{
    $pairs = array_map(
        function ($key, $val) {
            return [$key, $val];
        },
        array_keys($collection),
        array_values($collection)
    );

    return $pairs;
}