<?php

/**
 * extend function
 *
 * extend :: [a] [b] -> [a, b] 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const extend = "Chemem\\Bingo\\Functional\\Algorithms\\extend";

function extend(array $primary, array ...$exts) : array
{
    return array_merge($primary, ...$exts);
}
