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

function fill($list, $value, int $start, int $end)
{
    foreach ($list as $index => $val) {
        if (\is_object($list)) {
            $list->{$index} = $index >= $start && $index <= $end ? $value : $val;
        } else {
            if (\is_array($list)) {
                $list[$index] = $index >= $start && $index <= $end ? $value : $val;
            }
        }
    }

    return $list;
}
