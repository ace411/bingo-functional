<?php

/**
 * last function
 * 
 * last :: [a, b] -> b 
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const last = 'Chemem\\Bingo\Functional\\Algorithms\\last';

function last(array $collection)
{
    return end($collection);
}