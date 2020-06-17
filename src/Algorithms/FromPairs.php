<?php

/**
 * fromPairs function.
 *
 * fromPairs :: [[a, b]] -> [c]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const fromPairs = 'Chemem\\Bingo\\Functional\\Algorithms\\fromPairs';

function fromPairs($list)
{
    return _fold(function ($acc, $val) {
        if (\is_array($val) && \count($val) == 2) {
            $acc[head($val)] = last($val);
        }

        return $acc;
    }, $list, []);
}
