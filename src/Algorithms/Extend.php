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

function extend(array $primary, array ...$exts) : array
{
    $ret = [];
    
    if (!empty($primary)) {
        foreach ($primary as $key => $val) {
            if (is_string($key)) {
                $ret[$key] = $val;
            } else {
                $ret[] = $val;
            }            
        }
    }

    foreach ($exts as $ext) {
        foreach ($ext as $key => $val) {
            if (is_string($key)) {
                $ret[$key] = $val;
            } else {
                $ret[] = $val;
            }
        }
    }

    return $ret;
}
