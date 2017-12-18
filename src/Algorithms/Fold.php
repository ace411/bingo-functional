<?php

/**
 * fold function
 * 
 * fold :: (a -> b) -> [a] -> a
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0 
 */

namespace Chemem\Bingo\Functional\Algorithms;

const fold = "Chemem\\Bingo\\Functional\\Algorithms\\fold";

function fold(callable $func, array $collection, $acc)
{
    $collection = array_values($collection);

    foreach ($collection as $value) {
        $acc = call_user_func_array($func, [$acc, $value]);
    }

    return $acc;
}

/**
 * reduce function
 * 
 * reduce :: (a -> b) -> [a] -> a
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0 
 */

const reduce = "Chemem\\Bingo\\Functional\\Algorithms\\reduce";

function reduce(callable $func, array $collection, $acc)
{
    return fold($collection, $func, $acc);
}