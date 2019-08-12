<?php declare(strict_types=1);

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

function lastIndexOf(array $collection, $value)
{
    $func = compose(partial(indexesOf, $collection), last);

    return $func($value);
}