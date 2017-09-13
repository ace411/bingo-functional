<?php

/**
 * Head function
 *
 * head :: [a, b] -> a
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const head = "Chemem\\Bingo\\Functional\\Algorithms\\head";

function head(array $values)
{
    return reset($values);
}
