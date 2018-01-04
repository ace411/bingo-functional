<?php

namespace Chemem\Bingo\Functional\Algorithms;

const dropRight = "Chemem\\Bingo\\Functional\\Algorithms\\dropRight";

function dropRight(array $collection, int $number = 1, $acc = []) : array
{
    $collection = array_reverse($collection);

    foreach ($collection as $index => $value) {
        if ($index > $number - 1) {
            $acc[] = $value;
        }
    }

    return array_reverse($acc);
}