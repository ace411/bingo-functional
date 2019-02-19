<?php

/**
 *
 * zipWith function
 *
 * zipWith :: (a -> b -> c) -> [a] -> [b] -> [c]
 *
 * @see https://lodash.com/docs/4.17.11#zipWith
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const zipWith = 'Chemem\\Bingo\\Functional\\Algorithms\\zipWith';

function zipWith(callable $function, array ...$values) : array
{
    $zipped = zip(...$values);

    return map(function ($zip) use ($function) {
        return $function(...$zip);
    }, $zipped);
}
