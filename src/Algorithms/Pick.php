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

function pick($values, $search, $default = null)
{
    $acc = [];

    foreach ($values as $idx => $item) {
        if (is_array($values) && ($item == $search)) {
            $acc[] = $item;
        } elseif (is_object($values) && ($values->{$idx} == $search)) {
            $acc[] = $item;
        }
    }
    $result = head($acc);

    return is_null($result) ? $default : $result;
}
