<?php

/**
 * CurryN function.
 *
 * curryN :: (a, (b)) -> (b)
 *
 * @author Lochemem Bruno Michael
 * @license Apache 2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_curryN;

const curryN = 'Chemem\\Bingo\\Functional\\Algorithms\\curryN';

function curryN(int $paramCount, callable $function)
{
  return _curryN($paramCount, $function);
}

/**
 * CurryN function.
 *
 * curryRightN :: (a, (b)) -> (b)
 *
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */
const curryRightN = 'Chemem\\Bingo\\Functional\\Algorithms\\curryRightN';

function curryRightN(int $paramCount, callable $function)
{
  return _curryN($paramCount, $function, false);
}
