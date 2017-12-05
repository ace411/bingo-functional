<?php

/**
 * Throttle function
 *
 * throttle :: Callable a Int b -> a 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const throttle = "Chemem\\Bingo\\Functional\\Algorithms\\throttle";

function throttle(callable $fn, int $timeout)
{
    sleep($timeout);
    return call_user_func($fn);
}