<?php

/**
 * endsWith function
 * 
 * endsWith :: String -> String -> bool
 * 
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

const endsWith = __NAMESPACE__ . '\\endsWith';

function endsWith(string $haystack, string $needle): bool
{
    $strLen = mb_strlen($needle, 'utf-8');

    if ($strLen == 0)
        return false;

    return substr($haystack, -$strLen) === $needle;
}