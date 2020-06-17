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

function firstIndexOf($list, $value)
{
    $func = compose(partial(indexesOf, $list), head);

    return $func($value);
}
