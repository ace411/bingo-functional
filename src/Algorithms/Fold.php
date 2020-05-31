<?php

/**
 * fold function.
 *
 * fold :: (a -> b -> a) -> a -> [b] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const fold = 'Chemem\\Bingo\\Functional\\Algorithms\\fold';

function fold(callable $func, $collection, $acc)
{
    return _fold($func, $collection, $acc);
}

/**
 * foldRight function.
 *
 * foldRight :: (a -> b -> a) -> a -> [b] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */
const foldRight = 'Chemem\\Bingo\\Functional\\Algorithms\\foldRight';

function foldRight(callable $func, $collection, $acc)
{
    return _fold(
        $func,
        array_reverse(is_object($collection) ? \get_object_vars($collection) : $collection),
        $acc  
    );
}

/**
 * reduceRight function.
 *
 * foldRight :: (a -> b -> a) -> a -> [b] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */
const reduceRight = 'Chemem\\Bingo\\Functional\\Algorithms\\reduceRight';

function reduceRight(callable $func, array $collection, $acc)
{
    return foldRight($func, $collection, $acc);
}

/**
 * reduce function.
 *
 * reduce :: (a -> b -> a) -> a -> [b] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */
const reduce = 'Chemem\\Bingo\\Functional\\Algorithms\\reduce';

function reduce(callable $func, array $collection, $acc)
{
    return fold($func, $collection, $acc);
}
