<?php

/**
 * addKeys function.
 *
 * addKeys :: [a, b] -> [a] -> [a]
 *
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Algorithms;

const addKeys = 'Chemem\\Bingo\\Functional\\Algorithms\\addKeys';

function addKeys(array $collection, ...$keys) : array
{
    return fold(
        function ($acc, $val) use ($collection) {
            if (isset($collection[$val])) {
                $acc[$val] = $collection[$val];
            }

            return $acc;
        },
        $keys,
        identity([])
    );
}
