<?php

/**
 * pluckPath
 *
 * pluckPath :: [a] -> [b] -> c -> c
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const pluckPath = __NAMESPACE__ . '\\pluckPath';

function pluckPath(array $keys, $list, $default = null)
{
    return fold(function ($acc, $key) use ($default) {
        if (\is_object($acc)) {
            $acc = isset($acc->{$key}) ? $acc->{$key} : null;
        } elseif (\is_array($acc)) {
            $acc = isset($acc[$key]) ? $acc[$key] : null;
        }

        return \is_null($acc) ? $default : $acc;
    }, $keys, $list);
}
