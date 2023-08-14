<?php

/**
 * CurryN* functions
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_CurryN.php';

use function Chemem\Bingo\Functional\Internal\_curryN;

const curryN = __NAMESPACE__ . '\\curryN';

/**
 * curryN
 * converts an uncurried function to a curried one
 *
 * curryN :: Int -> ((a, b) -> c) -> a -> b -> c
 *
 * @param integer $paramCount
 * @param callable $function
 * @return callable
 * @example
 *
 * curryN(fn ($x, $y) => $x + $y)(2)(3)
 * => 5
 */
function curryN(int $paramCount, callable $function): callable
{
  return _curryN($paramCount, $function);
}
