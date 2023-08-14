<?php

/**
 * reduce
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

const reduce = __NAMESPACE__ . '\\reduce';

/**
 * alias of fold
 * @see fold
 */
function reduce(callable $func, $list, $acc)
{
  return fold($func, $list, $acc);
}
