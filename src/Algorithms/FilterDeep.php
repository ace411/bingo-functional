<?php

/**
 * filterDeep function
 *
 * filterDeep :: (a -> Bool) -> [a] -> [a]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const filterDeep = 'Chemem\\Bingo\\Functional\\Algorithms\\filterDeep';

function filterDeep(callable $function, array $values): array
{
    return _fold(function ($acc, $val, $idx) use ($function) {
        $acc[$idx] = \is_array($val) ?
            filterDeep($function, $val) :
            head(filter($function, [$val]));

        if ($acc[$idx] == null) {
            unset($acc[$idx]);
        }

        return $acc;
    }, $values, []);
}
