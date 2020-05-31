<?php

/**
 * Unique function.
 *
 * unique :: [a, a, b] -> [a, b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const unique = 'Chemem\\Bingo\\Functional\\Algorithms\\unique';

function unique(array $collection): array
{
    return _fold(function ($acc, $val, $idx) {
        if (!\in_array($val, $acc)) {
            $acc[$idx] = $val;
        }

        return $acc;
    }, $collection, []);
}
