<?php

/**
 * Partial function
 *
 * partial :: (a, b) -> (a) b
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const partial = "Chemem\\Bingo\\Functional\\Algorithms\\partial";

function partial(callable $fn, ...$args)
{
    return function (...$inner) use ($fn, $args) {
        return call_user_func_array(
            $fn,
            array_merge(
                func_get_args(),
                $args
            )
        );
    };
}
