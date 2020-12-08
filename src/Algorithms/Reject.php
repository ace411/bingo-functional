<?php

/**
 * reject function.
 *
 * reject :: (a -> Bool) -> [a] -> [a]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const reject = 'Chemem\\Bingo\\Functional\\Algorithms\\reject';

function reject(callable $func, $list)
{
    return _fold(function ($acc, $val, $idx) use ($func) {
        if ($func($val)) {
            if (\is_object($acc)) {
                unset($acc->{$idx});
            } elseif (\is_array($acc)) {
                unset($acc[$idx]);
            }
        }

        return $acc;
    }, $list, $list);
}
