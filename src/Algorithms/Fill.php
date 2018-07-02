<?php

/**
 * fill function.
 *
 * fill :: [a] -> b -> c -> d -> ([a], b, c, d) -> [e]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const fill = 'Chemem\\Bingo\\Functional\\Algorithms\\fill';

function fill(array $collection, $value, int $start, int $end) : array
{
    $vals = array_values($collection);
    $valCount = count($collection);

    $fillFunc = function (int $init, array $acc) use ($vals, $value, $end, &$fillFunc) {
        if ($init > $end) {
            return $acc;
        }

        $acc[$init] = $value;

        return $fillFunc($init + 1, $acc);
    };

    return $fillFunc($start, $vals);
}
