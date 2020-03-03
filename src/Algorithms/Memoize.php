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

function memoize(callable $function): callable
{
    return function () use ($function) {
        static $cache = [];

        $args = func_get_args();
        $key  = md5(serialize($args));

        if (function_exists('apcu_add')) {
            apcu_add($key, $function(...$args));
        }

        if (!isset($cache[$key])) {
            $cache[$key] = call_user_func_array($function, $args);
        }

        return !function_exists('apcu_fetch') ? $cache[$key] : apcu_fetch($key);
    };
}
