<?php

/**
 * mapDeep function.
 *
 * @package bingo-functional
 * @author Lochemem Bruno Michael
 * @license Apache-2.0
 */

namespace Chemem\Bingo\Functional;

use function Chemem\Bingo\Functional\Internal\_fold;

const mapDeep = __NAMESPACE__ . '\\mapDeep';

/**
 * mapDeep
 * transforms every entry in a list in a single iteration
 *
 * mapDeep :: (a -> b) -> [a] -> [b]
 *
 * @param callable $func
 * @param array $list
 * @return array
 * @example
 *
 * mapDeep('strtoupper', ['foo', ['bar', 'baz']])
 * => ['FOO', ['BAR', 'BAZ']]
 */
function mapDeep(callable $func, array $list): array
{
  return _fold(function ($acc, $val, $idx) use ($func) {
    $acc[$idx] = \is_array($val) ? mapDeep($func, $val) : $func($val);

    return $acc;
  }, $list, []);
}
