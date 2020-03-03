<?php

/**
 * filter function.
 *
 * filter :: (a -> Bool) -> [a] -> [a]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const filter = 'Chemem\\Bingo\\Functional\\Algorithms\\filter';

function filter(callable $func, array $collection): array
{
    $acc = [];

    foreach ($collection as $index => $value) {
        if ($func($value)) {
            $acc[$index] = $value;
        }
    }

    return $acc;
}

const filterT = __NAMESPACE__ . '\\filterT';

/**
 * filterT function
 * 
 * filterT :: [a] -> (a -> Bool) -> Bool -> Bool
 * 
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */
function filterT(
    array $collection, 
    callable $func, 
    bool $every = true
): bool
{
    $listCount  = count($collection);
    $filter     = compose(partial(filter, $func), function (array $result) use (
        $every, 
        $listCount
    ): bool {
        $resCount = count($result);
        return $every ? $listCount === $resCount : $resCount >= 1;
    });

    return $filter($collection);
}
