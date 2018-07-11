<?php

/**
 * DropRight function
 *
 * dropRight :: [a, b] Int c -> [a] 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const dropRight = "Chemem\\Bingo\\Functional\\Algorithms\\dropRight";

function dropRight(array $collection, int $number = 1, $acc = []) : array
{
    foreach (array_reverse($collection) as $index => $value) {
        if ($index > $number - 1) { $acc[$index] = $value; }
    }

    return array_reverse($acc);
}