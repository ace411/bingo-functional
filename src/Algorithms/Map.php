<?php

/**
 * map function
 * 
 * map :: (a -> b) -> [a] -> [b]
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0 
 */

namespace Chemem\Bingo\Functional\Algorithms;

const map = "Chemem\\Bingo\\Functional\\Algorithms\\map";

function map(callable $func, array $collection, $acc = []) : array
{
    $arrCount = count($collection); 
    $collection = array_values($collection); 

    foreach ($collection as $item => $value) {
        $acc[] = call_user_func($func, $value);
    }
    
    return $acc;
}