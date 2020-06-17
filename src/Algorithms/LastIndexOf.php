<?php

/**
 * lastIndexOf function
 *
 * lastIndexOf :: Hashtable k v -> v -> k
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const lastIndexOf = __NAMESPACE__ . '\\lastIndexOf';

function lastIndexOf($list, $value)
{
    $func = compose(partial(indexesOf, $list), last);

    return $func($value);
}
