<?php

namespace Chemem\Bingo\Functional\Algorithms;

const unique = "Chemem\\Bingo\\Functional\\Algorithms";

function unique(array $collection, $acc = []) : array
{
    foreach ($collection as $index => $value) {
        if (!in_array($value, $acc)) {
            $acc[$index] = $value;
        }
    }

    return $acc;
}