<?php

/**
 * filter function
 * 
 * filter :: (a -> Bool) -> [a] -> [a]
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const filter = "Chemem\\Bingo\\Functional\\Algorithms\\filter";

function filter(callable $func, array $collection) : array
{
    $arrCount = count($collection);
    $colVals = array_values($collection);

    $recursiveFilter = function (int $init = 0, array $acc = []) use (
        $func,
        $colVals,
        $arrCount,
        &$recursiveFilter
    ) {
        if ($init >= $arrCount) {
            return $acc;
        }

        if ($func($colVals[$init])) {
            $acc[] = $colVals[$init];
        }
        
        return $recursiveFilter($init + 1, $acc);
    };

    return $recursiveFilter();
}