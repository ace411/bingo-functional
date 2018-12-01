<?php

/**
 * fold function.
 *
 * fold :: (a -> b) -> [a] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const fold = 'Chemem\\Bingo\\Functional\\Algorithms\\fold';

function fold(callable $func, array $collection, $acc)
{
    foreach ($collection as $index => $value) {
        $acc = $func($acc, $value);
    }

    return $acc;
}

/**
 * foldR function.
 *
 * foldR :: (a -> b) -> [a] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */
const foldR = 'Chemem\\Bingo\\Functional\\Algorithms\\foldR';

function foldR(callable $func, array $collection, $acc)
{
    foreach (array_reverse($collection) as $index => $value) {
        $acc = $func($acc, $value);
    }

    return $acc;
}

/**
 * reduceR function.
 *
 * foldR :: (a -> b) -> [a] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */
const reduceR = 'Chemem\\Bingo\\Functional\\Algorithms\\reduceR';

function reduceR(callable $func, array $collection, $acc)
{
    return foldR($func, $collection, $acc);
}

/**
 * reduce function.
 *
 * reduce :: (a -> b) -> [a] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */
const reduce = 'Chemem\\Bingo\\Functional\\Algorithms\\reduce';

function reduce(callable $func, array $collection, $acc)
{
    return fold($func, $collection, $acc);
}
