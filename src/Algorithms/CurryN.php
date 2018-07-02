<?php

/**
 * CurryN function.
 *
 * curryN :: (a, (b)) -> (b)
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const curryN = 'Chemem\\Bingo\\Functional\\Algorithms\\curryN';

function curryN(int $paramCount, callable $fn)
{
    $acc = function ($args) use ($paramCount, $fn, &$acc) {
        return function () use ($paramCount, $args, $fn, $acc) {
            $args = array_merge($args, func_get_args());
            if ($paramCount <= count($args)) {
                return call_user_func_array($fn, $args);
            }

            return $acc($args);
        };
    };

    return $acc([]);
}

/**
 * CurryN function.
 *
 * curryRightN :: (a, (b)) -> (b)
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */
const curryRightN = 'Chemem\\Bingo\\Functional\\Algorithms\\curryRightN';

function curryRightN(int $paramCount, callable $func)
{
    $acc = function ($args) use ($paramCount, $func, &$acc) {
        return function () use ($paramCount, $args, $func, $acc) {
            $funcArgs = compose(
                partialRight('array_merge', func_get_args()),
                reverse
            )($args);

            if ($paramCount <= count($funcArgs)) {
                return call_user_func_array($func, $funcArgs);
            }

            return $acc($funcArgs);
        };
    };

    return $acc([]);
}
