<?php

/**
 * DropLeft function
 *
 * dropLeft :: [a, b] Int c -> [b] 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const dropLeft = "Chemem\\Bingo\\Functional\\Algorithms\\dropLeft";

function dropLeft(array $collection, int $number = 1, array $acc = []) : array
{
    foreach ($collection as $index => $value) {
        if ($index > $number - 1) { $acc[$index] = $value; }
    }

    return $acc;
} 