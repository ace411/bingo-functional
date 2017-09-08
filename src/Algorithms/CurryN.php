<?php

/**
 * CurryN function
 *
 * curryN :: (a, (b)) -> (b)
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const curryN = "Chemem\\Bingo\\Functional\\Algorithms\\curryN";

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
