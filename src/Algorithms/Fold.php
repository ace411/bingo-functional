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
    foreach ($collection as $index => $value) {
        $acc = $func($acc, $value);
    }

    return $acc;
}

/**
 * foldRight function
 * 
 * foldRight :: (a -> b) -> [a] -> a
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0 
 */

const foldRight = 'Chemem\\Bingo\\Functional\\Algorithms\\foldRight';

function foldRight(callable $func, array $collection, $acc)
{
    foreach (array_reverse($collection) as $index => $value) {
        $acc = $func($acc, $value);
    }

    return $acc;
}

/**
 * reduceRight function
 * 
 * foldRight :: (a -> b) -> [a] -> a
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0 
 */

const reduceRight = 'Chemem\\Bingo\\Functional\\Algorithms\\reduceRight';

function reduceRight(callable $func, array $collection, $acc)
{
    return foldRight($func, $collection, $acc);
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
    return fold($func, $collection, $acc);
}