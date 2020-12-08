<?php

/**
 * min function.
 *
 * min :: [a, b] -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const min = 'Chemem\\Bingo\\Functional\\Algorithms\\min';

function min($list)
{
    return fold(function ($acc, $val) {
        return $val < $acc ? $val : $acc;
    }, $list, \is_object($list) ? $list->{0} : $list[0]);
}
