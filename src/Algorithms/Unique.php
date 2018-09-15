<?php

/**
 * Unique function
 *
 * unique :: [a, a, b] -> [a, b] 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const unique = "Chemem\\Bingo\\Functional\\Algorithms\\unique";

function unique(array $collection) : array
{
    $valCount = count($collection);
    $arrKeys = array_keys($collection);

    $uniqueFn = function (int $init = 0, array $acc = []) use ( 
        $arrKeys, 
        $valCount, 
        &$uniqueFn,
        $collection
    ) {
        if ($init >= $valCount) {
            return $acc;
        }

        if (!in_array($collection[$arrKeys[$init]], $acc)) {
            $acc[$arrKeys[$init]] = $collection[$arrKeys[$init]];            
        }

        return $uniqueFn($init + 1, $acc);
    };

    return $uniqueFn();
}