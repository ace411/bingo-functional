<?php

namespace Chemem\Bingo\Functional\Algorithms;

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

function countOfValue(array $list, $value): int
{
    $count = 0;
    foreach ($list as $val) {
        $count += is_array($val) ?
            countOfValue($val, $value) :
            ($val == $value ? 1 : 0);
    }

    return $count;
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

function countOfKey(array $list, string $skey): int
{
    $count = 0;
    foreach ($list as $key => $val) {
        $count += is_array($val) ?
            countOfKey($val, $skey) :
            ($key == $skey ? 1 : 0);
    }

    return $count;
}
