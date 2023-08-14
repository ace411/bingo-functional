<?php

/**
 * foldRight
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

require_once __DIR__ . '/Internal/_Props.php';

use function Chemem\Bingo\Functional\Internal\_props;

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
  return fold($func, \array_reverse(_props($list)), $acc);
}
