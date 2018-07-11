<?php

/**
 * Partition function
 *
 * partition :: [a, b] Int b -> [[a], [b]]
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const partition = "Chemem\\Bingo\\Functional\\Algorithms\\partition";

function partition(int $number, array $array) : array
{
    if ($number < 2 || count($array) < 2) {
        return [$array];
    }

    $pSize = ceil(count($array) / $number);

    return array_merge(
        [array_slice($array, 0, $pSize)],
        partition($number - 1, array_slice($array, $pSize))
    );
}
