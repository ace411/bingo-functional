<?php

/**
 * 
 * omit function
 * 
 * omit :: [a] -> b -> a[b]
 * 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Algorithms;

const omit = 'Chemem\\Bingo\\Functional\\Algorithms\\omit';

function omit(array $collection, ...$keys) : array
{
    $diff = array_diff(array_keys($collection), $keys);

    return fold(
        function ($acc, $val) use ($collection) {
            $acc[$val] = $collection[$val];

            return $acc;
        },
        $diff,
        identity([])
    );
}
