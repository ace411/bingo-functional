<?php

/**
 * toException function
 * 
 * toException :: (a) -> (b(c)) -> d
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const toException = 'Chemem\\Bingo\\Functional\\Algorithms\\toException';

function toException(callable $func) : callable
{
    return function (...$args) use ($func) {
        try {
            return $func(...$args);
        } catch (\Exception $exception) {
            return $exception->getMessage();
        } finally {
            restore_error_handler();
        }
    };
}
