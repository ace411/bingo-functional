<?php

/**
 * every function
 * 
 * every :: [a] -> (b -> Bool) -> c
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const every = 'Chemem\\Bingo\\Functional\\Algorithms\\every';

function every(array $collection, callable $func) : bool
{
    $valCount = count($collection);

    $everyFn = compose(
        partialLeft(filter, $func),
        function (array $result) use ($valCount) {
            $resCount = count($result);

            return $resCount == $valCount;
        }
    );

    return $everyFn($collection);
}