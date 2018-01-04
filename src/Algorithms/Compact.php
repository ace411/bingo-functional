<?php

namespace Chemem\Bingo\Functional\Algorithms;

const compact = "Chemem\\Bingo\\Functional\\Algorithms\\compact";

function compact(array $collection) : array
{
    return filter(
        function ($value) {
            return !is_bool($value) && !is_null($value);
        },
        $collection
    );
}