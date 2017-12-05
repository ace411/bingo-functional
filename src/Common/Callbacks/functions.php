<?php

/**
 * Error callbacks
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Common\Callbacks;

use Chemem\Bingo\Functional\Algorithms as A;

const invalidArrayKey = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\invalidArrayKey";

function invalidArrayKey($key) : string
{
    return A\concat(' ', $key, 'does', 'not', 'exist');
}

const invalidArrayValue = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\invalidArrayValue";

function invalidArrayValue($search) : string
{
    return A\concat(' ', $search, 'does', 'not', 'exist', 'in', 'collection');
}

const emptyArray = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\emptyArray";

function emptyArray() : string
{
    return A\concat(' ', 'array', 'is', 'empty');
}

const memoizationError = "Chemem\\Bingo\\Functional\\Common\\Callbacks\\memoizationError";

function memoizationError(callable $function) : string
{
    $fnName = (new ReflectionFunction($function))
        ->getName();
    
    return A\concat(' ', $fnName, 'could', 'not', 'be', 'memoized');
}