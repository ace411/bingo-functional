<?php

/**
 *
 * intersects function
 *
 * intersects :: [a] -> [b] -> Bool
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const intersects = 'Chemem\\Bingo\\Functional\\Algorithms\\intersects';

function intersects(array $first, array $second) : bool
{
    $fSize = count($first);
    $sSize = count($second);
    $intersect = [];

    if ($fSize > $sSize) {
        foreach ($second as $val) {
            if (in_array($val, $first)) {
                $intersect[] = $val;
            }
        }
    } else {
        foreach ($first as $val) {
            if (in_array($val, $second)) {
                $intersect[] = $val;
            }
        }
    }

    return empty($intersect) ? false : true;
}
