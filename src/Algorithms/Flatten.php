<?php

/**
 * Flatten function.
 *
 * flatten :: [a, [b]] -> [a, b]
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const flatten = 'Chemem\\Bingo\\Functional\\Algorithms\\flatten';

function flatten(array $list, array $acc = []): array
{
    $flattened = fold(
        function ($acc, $value) {
            return \is_array($value) ? \array_merge($acc, flatten($value)) : \array_merge($acc, [$value]);
        },
        $list,
        $acc
    );

    return $flattened;
}
