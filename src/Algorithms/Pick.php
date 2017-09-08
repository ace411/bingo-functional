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

use Chemem\Bingo\Functional\Functors\Maybe\{Maybe, Just, Nothing};
use Chemem\Bingo\Functional\Common\Callbacks as C;

const pick = "Chemem\\Bingo\\Functional\\Algorithms\\pick";

function pick(array $values, $search)
{
    $picked = Maybe::fromValue($values)
        ->filter(
            function ($val) {
                return !empty($val);
            }
        )
        ->map(
            function ($arr) use ($search) {
                return array_key_exists($search, $arr) ?
                    $arr[$search] :
                    Maybe::nothing($arr);
            }
        );

    return $picked->isJust() ?
        $picked->getJust() :
        C\extractErrorMessage(
            C\invalidArrayKey($search)
        );
}
