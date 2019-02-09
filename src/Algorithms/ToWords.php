<?php

/**
 * 
 * toWords function
 * 
 * toWords :: a -> [a, b]
 * 
 * @see https://lodash.com/docs/4.17.11#words
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const toWords = 'Chemem\\Bingo\\Functional\\Algorithms\\toWords';

function toWords(string $string, string $regex = '') : array
{
    if ($regex == '') return explode(' ', $string);
    
    return preg_split($regex, $string);
}
