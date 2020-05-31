<?php

/**
 * filter function.
 *
 * filter :: (a -> Bool) -> [a] -> [a]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const filter = 'Chemem\\Bingo\\Functional\\Algorithms\\filter';

function filter(callable $func, $collection)
{
    return _fold(function ($acc, $val, $idx) use ($func) {
        if ($func($val)) {
            if (\is_object($acc)) {
                $acc->{$idx} = $val;
            } else {
                $acc[$idx] = $val;
            }
        } else {
            if (\is_object($acc)) {
                unset($acc->{$idx});
            } else {
                unset($acc[$idx]);
            }
        }

        return $acc;
    }, $collection, $collection);
}
