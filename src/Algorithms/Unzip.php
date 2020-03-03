<?php

/**
 * Unzip function.
 *
 * unzip :: [(a, b)] -> ([a], [b])
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const unzip = 'Chemem\\Bingo\\Functional\\Algorithms\\unzip';

function unzip(array $zipped, $acc = []): array
{
    $zippedValues = array_values($zipped);
    $zippedCount  = count($zippedValues[0]); //same for indexes 0 - n

    foreach ($zippedValues as $child) {
        $childValues = array_values($child);
        for ($i = 0; $i < $zippedCount; $i++) {
            $acc[$i][] = $childValues[$i];
        }
    }

    return $acc;
}
