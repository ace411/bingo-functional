<?php

/**
 * PartialRight function.
 *
 * partialRight :: (a, b) -> (b) a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const partialRight = 'Chemem\\Bingo\\Functional\\Algorithms\\partialRight';

function partialRight(callable $fn, ...$args)
{
    return function (...$inner) use ($fn, $args) {
        return $fn(...array_reverse(array_merge($args, $inner)));
    };
}
