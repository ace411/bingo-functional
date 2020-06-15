<?php

/**
 * Unzip function.
 *
 * unzip :: [(a, b)] -> ([a], [b])
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const unzip = 'Chemem\\Bingo\\Functional\\Algorithms\\unzip';

function unzip(array $zipped): array
{
    return _fold(function ($acc, $val, $idx) {
        for ($idx = 0; $idx < \count($val); $idx += 1) {
            $acc[$idx][] = $val[$idx];
        }

        return $acc;
    }, $zipped, []);
}
