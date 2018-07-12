<?php

/**
 * indexOf function.
 *
 * indexOf :: [a] -> b -> c -> ([a], b, c) -> d
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const indexOf = 'Chemem\\Bingo\\Functional\\Algorithms\\indexOf';

function indexOf(array $collection, $value, int $fromIndex = 0)
{
    $indexFn = function ($valIndex) use ($value, $fromIndex, $collection) {
        foreach ($collection as $index => $val) {
            if ($val == $value) {
                $valIndex = $index;
            }
        }

        return $valIndex;
    };

    return $indexFn(isArrayOf($collection) == 'string' ? identity('') : identity($fromIndex));
}
