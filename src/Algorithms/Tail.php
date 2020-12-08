<?php

/**
 * Tail function.
 *
 * tail :: [a, b] -> [b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const tail = 'Chemem\\Bingo\\Functional\\Algorithms\\tail';

function tail($list)
{
    [, $final] = fold(function ($acc, $val) {
        [$count, $lst] = $acc;
        $count = $count + 1;

        if ($count < 2) {
            if (\is_object($lst)) {
                unset($lst->{indexOf($lst, $val)});
            } else {
                if (\is_array($lst)) {
                    unset($lst[indexOf($lst, $val)]);
                }
            }
        }

        return [$count, $lst];
    }, $list, [0, $list]);

    return $final;
}
