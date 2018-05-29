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
    $colKeys = array_keys($collection);
    $colVals = array_values($collection);

    $recursiveMap = function (int $init = 0, array $acc = []) use (
        $func, 
        $colVals,
        $colKeys, 
        $arrCount, 
        &$recursiveMap
    ) {
        if ($init >= $arrCount) {
            return $acc;
        }

        $acc[$colKeys[$init]] = $func($colVals[$init]);

        return $recursiveMap($init + 1, $acc);
    };

    return $recursiveMap();
}