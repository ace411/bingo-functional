<?php

/**
 * mean function
 * 
 * mean :: [a, b] -> Float c
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const mean = 'Chemem\\Bingo\\Functional\\Algorithms\\mean';

function mean(array $collection) : float
{
    $divisor = fold(function ($acc, $val) { return $val + $acc; }, $collection, 0);

    return $divisor / count($collection);
}