<?php

/**
 * mapDeep function.
 *
 * mapDeep :: (a -> b) -> [a] -> [b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const mapDeep = 'Chemem\\Bingo\\Functional\\Algorithms\\mapDeep';

function mapDeep(callable $func, array $collection): array
{
    return _fold(function ($acc, $val, $idx) use ($func) {
        $acc[$idx] = \is_array($val) ? mapDeep($func, $val) : $func($val);

        return $acc;
    }, $collection, []);
}
