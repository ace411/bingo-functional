<?php

/**
 * Curry function.
 *
 * curry :: ((a, b), c) -> a -> b -> c
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use Chemem\Bingo\Functional\Algorithms as A;

const curry = 'Chemem\\Bingo\\Functional\\Algorithms\\curry';

function curry(callable $fn, $required = true): callable
{
  $func = new \ReflectionFunction($fn);

  return A\curryN(
        $required === true ?
            $func->getNumberOfRequiredParameters() :
            $func->getNumberOfParameters(),
        $fn
    );
}

/**
 * curryRight function.
 *
 * curryRight :: ((a, b), c) -> c -> b -> a
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */
const curryRight = 'Chemem\\Bingo\\Functional\\Algorithms\\curryRight';

function curryRight(callable $func, $required = true): callable
{
  $toCurry = new \ReflectionFunction($func);

  $paramCount = $required ?
        $toCurry->getNumberOfRequiredParameters() :
        $toCurry->getNumberOfParameters();

  return curryRightN($paramCount, $func);
}
