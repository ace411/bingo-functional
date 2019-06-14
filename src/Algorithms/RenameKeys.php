<?php

/**
 *
 * renameKeys function
 *
 * renameKeys :: HashTable k v -> HashTable k a -> HashTable a v
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const renameKeys = __NAMESPACE__ . '\\renameKeys';

function renameKeys(array $list, array $keyPair): array
{
    foreach ($list as $key => $val) {
        foreach ($keyPair as $_key => $_val) {
            if (key_exists($_key, $list)) {
                $list[$_val] = $list[$_key];
                unset($list[$_key]);
            }
        }
    }

    return $list;
}
