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

function flatten(array $list): array
{
    $flattened = fold(
        function ($acc, $value) {
        return \is_array($value) ?
        extend($acc, flatten($value)) :
        extend($acc, [$value]);
    },
        $list,
        []
    );

    return $flattened;
}
