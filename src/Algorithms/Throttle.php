<?php

/**
 * Throttle function.
 *
 * throttle :: (a) -> Int b -> (a) -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const throttle = 'Chemem\\Bingo\\Functional\\Algorithms\\throttle';

function throttle(callable $function, int $timeout): callable
{
    \sleep($timeout);

    return function (...$args) use ($function) {
        return $function(...$args);
    };
}
