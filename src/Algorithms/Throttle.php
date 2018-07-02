<?php

/**
 * Throttle function.
 *
 * throttle :: Callable a Int b -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const throttle = 'Chemem\\Bingo\\Functional\\Algorithms\\throttle';

function throttle(callable $function, int $timeout)
{
    sleep($timeout);

    return function (...$args) use ($function) {
        return call_user_func_array($function, $args);
    };
}
