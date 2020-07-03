<?php

/**
 * map function.
 *
 * map :: (a -> b) -> [a] -> [b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const map = 'Chemem\\Bingo\\Functional\\Algorithms\\map';

function map(callable $func, $list)
{
    return _fold(function ($acc, $val, $idx) use ($func) {
        if (\is_object($acc)) {
            $acc->{$idx} = $func($val);
        } elseif (\is_array($acc)) {
            $acc[$idx] = $func($val);
        }

        return $acc;
    }, $list, $list);
}
