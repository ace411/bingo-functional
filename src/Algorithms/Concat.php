<?php

/**
 * Concat function
 * 
 * concat :: String a, [b] -> (a, [b]) -> String c
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

function concat(string $wildcard = '', string ...$strings) : string
{
    return implode($wildcard, $strings);
}