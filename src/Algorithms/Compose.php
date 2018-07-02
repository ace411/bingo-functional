<?php

/**
 * Compose function.
 *
 * compose :: f (g a) -> compose f g a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use Chemem\Bingo\Functional\Algorithms as A;

const compose = 'Chemem\\Bingo\\Functional\\Algorithms\\compose';

function compose(callable ...$functions)
{
    return array_reduce(
        $functions,
        function ($id, $fn) {
            return function ($val) use ($id, $fn) {
                return $fn($id($val));
            };
        },
        A\identity
    );
}
