<?php

/**
 * trampoline function
 * 
 * trampoline :: (a) -> (b) -> a(b) -> c
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const trampoline = 'Chemem\\Bingo\\Functional\\Algorithms\\trampoline';

function trampoline(callable $func)
{
    $finalArgs = [];
    $recursing = false;

    return function (...$args) use ($func, $finalArgs, $recursing) {
        $finalArgs[] = $args;

        if (!$recursing) {
            $recursing = true;

            while (!empty($finalArgs)) { $result = $func(...array_shift($finalArgs)); }

            $recursing = false;
        }

        return $result;
    };
}