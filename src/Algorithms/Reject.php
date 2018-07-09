<?php

/**
 * reject function
 * 
 * reject :: (a -> Bool) -> [a] -> [a]
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const reject = 'Chemem\\Bingo\\Functional\\Algorithms\\reject';

function reject(callable $func, array $collection) : array
{
    $count = count($collection);
    $keys = array_keys($collection);

    $rejectFn = function (int $init = 0, array $acc = []) use ($keys, $func, $count, &$rejectFn, $collection) {
        if ($init >= $count) { return $acc; }

        if (!$func($collection[$keys[$init]])) { $acc[$keys[$init]] = $collection[$keys[$init]]; } 

        return $rejectFn($init + 1, $acc);
    };

    return $rejectFn();
} 