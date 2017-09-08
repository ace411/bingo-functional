<?php

/**
 * Pluck function
 *
 * pluck :: [a] -> b -> b
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use Chemem\Bingo\Functional\Functors\Maybe\{Maybe, Just, Nothing};
use Chemem\Bingo\Functional\Common\Callbacks as C;

const pluck = "Chemem\\Bingo\\Functional\\Algorithms\\pluck";

function pluck(array $values, $search)
{
    $value = Maybe::fromValue($values)
        ->filter(
            function ($arr) {
                return is_array($arr);
            }
        )
        ->map(
            function ($arr) use ($search) {
                return array_reduce(
                    array_filter(
                        $arr,
                        function ($val) use ($search) {
                            return is_object($val) ?
                                 $val == $search :
                                 $val === $search;
                        }
                    ),
                    function ($carry, $val) {
                        return is_object($val) ? $val : $carry . $val;
                    },
                    ''
                );
            }
        );
        
    return $value->isJust() ?
        $value->getJust() :
        C\extractErrorMessage(
            C\invalidArrayElement($search)
        );
}
