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

function firstIndexOf(array $collection, $value)
{
    $func = compose(partial(indexesOf, $collection), head);

    return $func($value);
}
