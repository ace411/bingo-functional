<?php

/**
 * extend function.
 *
 * extend :: [a] [b] -> [a, b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const extend = 'Chemem\\Bingo\\Functional\\Algorithms\\extend';

function extend(array ...$lists) : array
{
    $ret = [];

    foreach ($lists as $list) {
        foreach ($list as $key => $val) {
            if (is_string($key)) {
                $ret[$key] = $val;
            } else {
                $ret[] = $val;
            }
        }
    }

    return $ret;
}
