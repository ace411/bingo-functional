<?php

/**
 * arrayKeysExist function.
 *
 * arrayKeysExist :: [a] b -> (b -> [a]) -> Bool c
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const arrayKeysExist = __NAMESPACE__ . '\\arrayKeysExist';

function arrayKeysExist(array $list, ...$keys): bool
{
    $intersect = \array_intersect(\array_keys($list), $keys);

    return \count($intersect) !== \count($keys) ? identity(false) : identity(true);
}

const keysExist = __NAMESPACE__ . '\\keysExist';

function keysExist(array $list, ...$keys): bool
{
    return arrayKeysExist($list, ...$keys);
}
