<?php

/**
 * Pluck function.
 *
 * pluck :: [a] -> b -> b
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const pluck = 'Chemem\\Bingo\\Functional\\Algorithms\\pluck';

function pluck($values, $search, $default = null)
{
    return _fold(function ($acc, $val, $idx) use ($search) {
        if ($search == $idx) {
            $acc = $val;
        }

        return $acc;
    }, $values, $default);
}
