<?php

/**
 * Pick function
 *
 * pick :: [a] -> b -> b
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const pick = "Chemem\\Bingo\\Functional\\Algorithms\\pick";

function pick(array $values, $search, callable $callback)
{
    $valueIndex = array_search($search, $values);

    return $valueIndex !== false ? 
        $values[$valueIndex] :
        call_user_func($callback, $valueIndex);
}
