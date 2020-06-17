<?php

/**
 * addKeys function.
 *
 * addKeys :: [a, b] -> [a] -> [a]
 *
 * @author Lochemem Bruno Michael
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const addKeys = 'Chemem\\Bingo\\Functional\\Algorithms\\addKeys';

function addKeys($list, ...$keys)
{
    return _fold(function ($acc, $val, $idx) use ($keys) {
        if (\in_array($idx, $keys)) {
            if (\is_object($acc)) {
                $acc->{$idx} = $val;
            } elseif (\is_array($acc)) {
                $acc[$idx] = $val;
            }
        } else {
            if (\is_object($acc)) {
                unset($acc->{$idx});
            } elseif (\is_array($acc)) {
                unset($acc[$idx]);
            }
        }

        return $acc;
    }, $list, $list);
}
