<?php

/**
 * any function.
 *
 * any :: [a] -> (b -> Bool) -> c
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const any = 'Chemem\\Bingo\\Functional\\Algorithms\\any';

function any(array $collection, callable $func) : bool
{
    $evalAny = compose(
        partialLeft(filter, $func),
        function (array $result) {
            $resCount = count($result);

            return $resCount >= 1;
        }
    );

    return $evalAny($collection);
}
