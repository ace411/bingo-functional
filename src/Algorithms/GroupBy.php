<?php

/**
 * groupBy function
 * 
 * groupBy :: [a] -> b -> [c]
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const groupBy = 'Chemem\\Bingo\\Functional\\Algorithms\\groupBy';

function groupBy(array $collection, $key) : array
{
    $groupFn = function (array $acc = []) use ($collection, $key) {
        foreach ($collection as $index => $value) {
            $acc[$value[$key]][] = isset($collection[$index][$key]) ? $value : [];
        }

        return $acc;
    };

    return isArrayOf($collection) == 'array' ? $groupFn() : $collection;
}