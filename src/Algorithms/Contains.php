<?php

/**
 * contains function
 *
 * contains :: String -> String -> bool
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const contains = __NAMESPACE__ . '\\contains';

function contains(string $haystack, string $needle): bool
{
    return strpos($haystack, $needle) !== false;
}
