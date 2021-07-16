<?php

/**
 * fold function
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional\Algorithms;

use function Chemem\Bingo\Functional\Algorithms\Internal\_fold;

const fold = __NAMESPACE__ . '\\fold';

/**
 * fold
 * transforms a list into a single value
 *
 * fold :: (a -> b -> c) -> [b] -> a -> a
 *
 * @param callable $func
 * @param array|object $list
 * @param mixed $acc
 * @return mixed
 * @example
 *
 * fold(fn ($x, $y) => $x > $y ? $x : $y, [3, 8, 2], 0)
 * => 8
 */
function fold(callable $func, $list, $acc)
{
  return _fold($func, $list, $acc);
}

const foldRight = __NAMESPACE__ . '\\foldRight';

/**
 * foldRight
 * version of fold that iterates from back to front
 *
 * fold :: (a -> b -> c) -> [b] -> a -> a
 *
 * @param callable $func
 * @param array|object $list
 * @param mixed $acc
 * @return mixed
 * @example
 *
 * foldRight(fn ($x, $y) => $x . $y, ['foo', 'bar'], 0);
 * => 'barfoo'
 */
function foldRight(callable $func, $list, $acc)
{
  return _fold(
    $func,
    \array_reverse(\is_object($list) ? \get_object_vars($list) : $list),
    $acc
  );
}

const reduceRight = __NAMESPACE__ . '\\reduceRight';

/**
 * alias of foldRight
 * @see foldRight
 */
function reduceRight(callable $func, array $list, $acc)
{
  return foldRight($func, $list, $acc);
}

const reduce = __NAMESPACE__ . '\\reduce';

/**
 * alias of fold
 * @see fold
 */
function reduce(callable $func, array $list, $acc)
{
  return fold($func, $list, $acc);
}
