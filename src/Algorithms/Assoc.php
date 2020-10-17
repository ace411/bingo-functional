<?php

/**
 * assoc function
 *
 * assoc :: a -> b -> [b] -> [b]
 *
 * @see https://ramdajs.com/docs/#assoc
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const assoc = __NAMESPACE__ . '\\assoc';

function assoc($key, $val, $list)
{
    return _fold(function ($acc, $entry, $idx) use ($key, $val) {
        if (\is_object($acc)) {
            if ($key == $idx) {
                $acc->{$idx} = $entry;
            }

            $acc->{$key} = $val;
        } elseif (\is_array($acc)) {
            if ($key == $idx) {
                $acc[$idx] = $entry;
            }

            $acc[$key] = $val;
        }

        return $acc;
    }, $list, $list);
}
