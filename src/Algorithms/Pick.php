<?php

/**
 * Pick function.
 *
 * pick :: [a] -> b -> b
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const pick = 'Chemem\\Bingo\\Functional\\Algorithms\\pick';

function pick(array $values, $search)
{
    $acc = [];

    foreach ($values as $value) {
        if ($value == $search) {
            $acc[] = $value;
        }
    }

    return head($acc);
}
