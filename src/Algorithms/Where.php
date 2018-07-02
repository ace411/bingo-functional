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

function where(array $collection, array $search) : array
{
    $arrCount = count($collection);
    list($searchKey, $searchVal) = head(toPairs($search));

    $whereFn = function (int $init = 0, array $acc = []) use (
        $arrCount,
        &$whereFn,
        $searchKey,
        $searchVal,
        $collection
    ) {
        if ($init >= $arrCount) {
            $result = filter(
                function ($val) {
                    return !empty($val);
                },
                $acc
            );

            return $result;
        }

        $acc[] = isset($collection[$init][$searchKey]) &&
            $collection[$init][$searchKey] == $searchVal ?
                $collection[$init] :
                [];

        return $whereFn($init + 1, $acc);
    };

    return isArrayOf($collection) == 'array' ? $whereFn() : $collection;
}
