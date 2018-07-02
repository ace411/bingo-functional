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

const pluck = 'Chemem\\Bingo\\Functional\\Algorithms\\pluck';

function pluck(array $values, $search)
{
    return isset($values[$search]) ? $values[$search] : false;
}
