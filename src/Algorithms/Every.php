<?php

/**
 * every function.
 *
 * every :: [a] -> (a -> Bool) -> Bool
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const every = 'Chemem\\Bingo\\Functional\\Algorithms\\every';

function every($list, callable $func): bool
{
    [$filterCount, $valCount] = fold(function ($acc, $val) use ($func) {
        [$fst, $snd] = $acc;
        $fst = $fst + 1;

        $snd += $func($val) ? 1 : 0;

        return [$fst, $snd];
    }, $list, [0, 0]);

    return $filterCount == $valCount;
}
