<?php

/**
 * map function
 * 
 * map :: (a -> b) -> [a] -> [b]
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0 
 */

namespace Chemem\Bingo\Functional\Algorithms;

const map = "Chemem\\Bingo\\Functional\\Algorithms\\map";

function map(callable $func, array $collection) : array
{
    $arrCount = count($collection); 
    $colVals = array_values($collection);

    $recursiveMap = function (int $init = 0, array $acc = []) use (
        $func, 
        $colVals, 
        $arrCount, 
        &$recursiveMap
    ) {
        if ($init >= $arrCount) {
            return $acc;
        }

        $acc[] = $func($colVals[$init]);

        return $recursiveMap($init + 1, $acc);
    };

    return $recursiveMap();
}