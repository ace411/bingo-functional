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
    $arrCount = count($collection);
    $colVals = array_values($collection);

    $recursiveFold = function (int $init, $mult) use (
        $func,
        $colVals,
        $arrCount,
        &$recursiveFold
    ) {
        if ($init >= $arrCount) {
            return $mult;
        }

        $mult = call_user_func_array($func, [$mult, $colVals[$init]]);

        return $recursiveFold($init + 1, $mult);
    };

    return $recursiveFold(0, $acc);
}

/**
 * foldRight function.
 *
 * foldRight :: (a -> b) -> [a] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */
const foldRight = 'Chemem\\Bingo\\Functional\\Algorithms\\foldRight';

function foldRight(callable $func, array $collection, $acc)
{
    $arrCount = count($collection);
    $colVals = array_values($collection);

    $recursiveFold = function (int $init, $mult) use (
        $func,
        $colVals,
        &$recursiveFold
    ) {
        if ($init < 0) {
            return $mult;
        }

        $mult = call_user_func_array($func, [$mult, $colVals[$init]]);

        return $recursiveFold($init - 1, $mult);
    };

    return $recursiveFold($arrCount - 1, $acc);
}

/**
 * reduceRight function.
 *
 * foldRight :: (a -> b) -> [a] -> a
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
