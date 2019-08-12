<?php declare(strict_types=1);

/**
 * indexesOf function
 *
 * indexesOf :: Hashtable k v -> v -> [k]
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const indexesOf = __NAMESPACE__ . '\\indexesOf';

function indexesOf(array $collection, $value): array
{
    $indexes = [];
    foreach ($collection as $idx => $val) {
        if (!is_array($val)) {
            if ($val === $value) {
                $indexes[] = $idx;
            }
        } else {
            $indexes[] = indexesOf($val, $value);
        }
    }

    return flatten($indexes);
}