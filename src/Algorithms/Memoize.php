<?php

/**
 * memoize function.
 *
 * memoize :: (a) -> (a -> b) -> (a)
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const memoize = 'Chemem\\Bingo\\Functional\\Algorithms\\memoize';

function memoize(callable $function)
{
    return function () use ($function) {
        static $cache = [];

        $args = func_get_args();
        $key = md5(serialize($args));

        if (!isset($cache[$key])) {
            $cache[$key] = call_user_func_array($function, $args);
        }

        return $cache[$key];
    };
}
