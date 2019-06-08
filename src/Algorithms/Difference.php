<?php

/**
 *
 * difference function
 *
 * difference :: [a] -> [a, c] -> [c] 
 *
 * @see https://lodash.com/docs/4.17.11#difference
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const difference = __NAMESPACE__ . '\\difference';

function difference(array ...$array): array
{
    $ret = compose(flatten, function (array $data) {
        $res = [];
        foreach ($data as $val) {
            if (countOfValue($data, $val) < 2)
                $res[] = $val;
        }

        return $res;
    });

    return $ret($array);
}
