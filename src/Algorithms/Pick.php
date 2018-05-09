<?php

/**
 * Pick function
 *
 * pick :: [a] -> b -> b
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const pick = "Chemem\\Bingo\\Functional\\Algorithms\\pick";

function pick(array $values, $search)
{
    $valCount = count($values);
    $arrVals = array_values($values);

    $pickFn = function (int $init = 0, array $acc = []) use ( 
        $search, 
        &$pickFn,
        $arrVals,
        $valCount
    ) {
        if ($init >= $valCount) {
            return head(
                filter(
                    function ($val) {
                        return !is_null($val);
                    },
                    $acc
                )
            );
        }

        $acc[] = $arrVals[$init] == $search ? $arrVals[$init] : null;

        return $pickFn($init + 1, $acc);
    };
    
    return $pickFn();
}
