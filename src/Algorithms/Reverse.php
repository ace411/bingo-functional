<?php

/**
 * reverse function
 * 
 * reverse :: [a] -> [b]
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const reverse = 'Chemem\\Bingo\\Functional\\Algorithms\\reverse';

function reverse(array $collection) : array
{
    $size = count($collection);

    $reverseFn = function (int $init, array $acc = []) use ($collection, &$reverseFn) {
        if ($init < 0) {
            return $acc;
        }

        $acc[] = $collection[$init];

        return $reverseFn($init - 1, $acc);
    };

    return $reverseFn($size - 1);
}