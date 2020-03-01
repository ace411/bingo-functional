<?php

/**
 * PartialLeft function.
 *
 * partialLeft :: (a, b) -> (a) b
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const partialLeft = 'Chemem\\Bingo\\Functional\\Algorithms\\partialLeft';

function partialLeft(callable $func, ...$args)
{
    return partialT($func, $args);
}

const partial = 'Chemem\\Bingo\\Functional\\Algorithms\\partial';

function partial(callable $func, ...$args)
{
    return partialLeft($func, ...$args);
}

function partialT(callable $func, array $args, bool $left = true)
{
    $argCount   = (new \ReflectionFunction($func))
        ->getNumberOfRequiredParameters();

    $acc        = function (...$inner) use (&$acc, $func, $argCount, $left) {
        return function (...$innermost) use (
            $inner, 
            $acc, 
            $func, 
            $left, 
            $argCount
        ) {
            $final = $left ? 
                array_merge($inner, $innermost) : 
                array_merge(array_reverse($innermost), array_reverse($inner));

            if ($argCount <= count($final)) {
                return $func(...$final);
            }

            return $acc(...$final);
        };
    }; 

    return $acc(...$args);
}
