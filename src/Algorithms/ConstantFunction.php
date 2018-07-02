<?php

/**
 * constant function.
 *
 * constantFunction :: a -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const constantFunction = 'Chemem\\Bingo\\Functional\\Algorithms\\constantFunction';

function constantFunction(...$args)
{
    return function () use ($args) {
        return $args[0];
    };
}
