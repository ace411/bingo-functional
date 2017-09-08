<?php

/**
 * memoize function
 *
 * memoize :: (a) -> (a -> b) -> (a)
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use Chemem\Bingo\Functional\Common\Callbacks as C;

const memoize = "Chemem\\Bingo\\Functional\\Algorithms\\memoize";

function memoize(callable $fn) : callable
{
    return function () use ($fn) {
        static $cache = [];

        $args = func_get_args();
        $key = md5(serialize($args));

        return !isset($cache[$key]) ?
            $cache[$key] = call_user_func_array($fn, $args) :
            C\extractErrorMessage(
                C\memoizationFailure($key, $fn)
            );
    };
}
