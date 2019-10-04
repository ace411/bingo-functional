<?php

/**
 * where function.
 *
 * where :: [a] -> [b] -> [c]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const where = 'Chemem\\Bingo\\Functional\\Algorithms\\where';

function where(array $collection, array $search): array
{
    list($searchKey, $searchVal) = head(toPairs($search));

    $whereFn = function (array $acc = []) use ($searchKey, $searchVal, $collection) {
        foreach ($collection as $index => $value) {
            if (isset($collection[$index][$searchKey]) && $collection[$index][$searchKey] == $searchVal) {
                $acc[] = $value;
            }
        }

        return $acc;
    };

    return isArrayOf($collection) == 'array' ? $whereFn() : $collection;
}
