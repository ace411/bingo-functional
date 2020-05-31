<?php

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

/**
 *
 * countOfValue function
 *
 * countOfValue :: [a, b] -> b -> Int
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

const countOfValue = __NAMESPACE__ . '\\countOfValue';

function countOfValue($list, $value): int
{
    return _fold(function ($acc, $val) use ($value) {
        if (is_array($val)) {
            $acc += countOfValue($val, $value);
        }

        $acc += ($val == $value);
        return $acc;
    }, $list, 0);
}

/**
 *
 * countOfKey function
 *
 * countOfKey :: [a, b] -> String -> Int
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

const countOfKey = __NAMESPACE__ . '\\countOfKey';

function countOfKey($list, $key): int
{
    return _fold(function ($acc, $val, $idx) use ($key) {
        if (is_array($val)) {
            $acc += countOfKey($val, $key);
        }

        $acc += is_string($key) ? 
            ((string) $idx == $key ? 1 : 0) : 
            ($idx == $key ? 1 : 0);
        
        return $acc;
    }, $list, 0);
}
