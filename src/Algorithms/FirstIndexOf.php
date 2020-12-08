<?php

/**
 * firstIndexOf function
 *
 * firstIndexOf :: Hashtable k v -> v -> k
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const firstIndexOf = __NAMESPACE__ . '\\firstIndexOf';

function firstIndexOf($list, $value, $def = null)
{
    $acc = $def;

    foreach ($list as $key => $entry) {
        if ($value == $entry) {
            $acc = $key;
        }

        if (\is_object($entry) || \is_array($entry)) {
            $acc = firstIndexOf($entry, $value, $def);
        }
    }

    return $acc;
}
