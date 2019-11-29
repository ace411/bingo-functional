<?php

/**
 * toException function.
 *
 * toException :: (a -> b) -> (c -> d) -> a -> d
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const toException = 'Chemem\\Bingo\\Functional\\Algorithms\\toException';

function toException(callable $func, callable $handler = null): callable
{
    return function (...$args) use ($func, $handler) {
        try {
            return $func(...$args);
        } catch (\Throwable $exception) {
            return isset($handler) ?
                $handler($exception) :
                $exception->getMessage();
        } finally {
            restore_error_handler();
        }
    };
}
