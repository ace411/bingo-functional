<?php

/**
 * isArrayOf function
 *
 * isArrayOf :: [a] -> b
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use Chemem\Bingo\Functional\Common\Callbacks as C;

const isArrayOf = "Chemem\\Bingo\\Functional\\Algorithms\\isArrayOf";

function isArrayOf(array $values)// : string
{
    $types = array_map(
        function ($el) {
            return gettype($el);
        },
        $values
    );
    $commonType = array_unique($types);
    $typeCount = count($commonType);
    return $typeCount > 1 ?
        'mixed' :
        implode('', $commonType);
}
